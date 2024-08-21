<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'vendor/autoload.php';

class Bonaicontent extends Module
{
    private $container;

    public $hasSubscription = false;

    public function __construct()
    {
        $this->name = 'bonaicontent';
        $this->tab = 'administration';
        $this->version = '1.0.3';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = 'b8fc614f82c4219a8333516a9a351f61';
        parent::__construct();
        $this->default_language = Language::getLanguage(Configuration::get('PS_LANG_DEFAULT'));
        $this->id_shop = Context::getContext()->shop->id;
        $this->displayName = $this->l('ChatGPT - OpenAI Content Generator');
        $this->description = $this->l('Creating SEO-friendly titles, summaries, and descriptions');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        if (null === $this->container) {
            $this->container = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
                $this->name,
                $this->getLocalPath()
            );
        }
    }

    protected function getConfigurations()
    {
        $configurations = [
            'BON_AI_TITLE_MAX' => 10,
            'BON_AI_SUMMARY_MAX' => 50,
            'BON_AI_PR_DESC_MAX' => 300,
            'BON_AI_PR_META_TITLE_MAX' => 10,
            'BON_AI_PR_META_DESC_MAX' => 30,
            'BON_AI_CAT_META_DESC_MAX' => 30,
            'BON_AI_CAT_DESC_MAX' => 300,
            'BON_AI_MARKETPLAC_DESC' => 300,
        ];

        return $configurations;
    }

    public function createAjaxController()
    {
        $tab = new Tab();
        $tab->active = 1;
        $languages = Language::getLanguages(false);
        if (is_array($languages)) {
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] = 'bonaicontent';
            }
        }
        $tab->class_name = 'AdminAjaxBonAIContent';
        $tab->module = $this->name;
        $tab->id_parent = -1;

        return (bool) $tab->add();
    }

    private function removeAjaxContoller()
    {
        if ($tab_id = (int) Tab::getIdFromClassName('AdminAjaxBonAIContent')) {
            $tab = new Tab($tab_id);
            $tab->delete();
        }

        return true;
    }

    public function install()
    {
        $configurations = $this->getConfigurations();

        foreach ($configurations as $name => $config) {
            Configuration::updateValue($name, $config);
        }

        return parent::install()
        && $this->createAjaxController()
        && $this->registerHook('displayAdminProductsSeoStepBottom')
        && $this->registerHook('displayAdminProductsMainStepLeftColumnMiddle')
        && $this->registerHook('displaybackOfficeCategory')
        && $this->registerHook('displayBackOfficeHeader')
        && $this->getService('bonaicontent.ps_accounts_installer')->install();
    }

    public function getService($serviceName)
    {
        return $this->container->getService($serviceName);
    }

    public function uninstall()
    {
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            Configuration::deleteByName($config);
        }

        return parent::uninstall()
        && $this->removeAjaxContoller();
    }

    public function getContent()
    {
        $output = '';

        if ((bool) Tools::isSubmit('submitSettings')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        $this->context->smarty->assign('module_dir', $this->_path);
        $accountsService = null;
        try {
            $accountsFacade = $this->getService('bonaicontent.ps_accounts_facade');
            $accountsService = $accountsFacade->getPsAccountsService();
        } catch (\PrestaShop\PsAccountsInstaller\Installer\Exception\InstallerException $e) {
            $accountsInstaller = $this->getService('bonaicontent.ps_accounts_installer');
            $accountsInstaller->install();
            $accountsFacade = $this->getService('bonaicontent.ps_accounts_facade');
            $accountsService = $accountsFacade->getPsAccountsService();
        }

        try {
            Media::addJsDef([
                'contextPsAccounts' => $accountsFacade->getPsAccountsPresenter()
                    ->present($this->name),
            ]);

            // Retrieve the PrestaShop Account CDN
            $this->context->smarty->assign('urlAccountsCdn', $accountsService->getAccountsCdn());
        } catch (Exception $e) {
            $this->context->controller->errors[] = $e->getMessage();

            return '';
        }

        /**********************
         * PrestaShop Billing *
         * *******************/

        // Load the context for PrestaShop Billing
        $billingFacade = $this->getService('bonaicontent.ps_billings_facade');
        $partnerLogo = $this->getLocalPath() . 'views/img/partnerLogo.png';

        // Retrieve the subscritpion for this module
        $subscription = $this->getService('bonaicontent.ps_billings_service')->getCurrentSubscription();
        $this->hasSubscription = ($subscription && true == $subscription['success']);

        // PrestaShop Billing
        Media::addJsDef($billingFacade->present([
            'logo' => $partnerLogo,
            'tosLink' => 'https://api.bontheme.com/modules/bonaicontent/terms-and-conditions-of-use.html',
            'privacyLink' => 'https://api.bontheme.com/modules/bonaicontent/terms-and-conditions-of-use.html',
            'emailSupport' => 'bonpresta@gmail.com',
            'currentSubscription' => $subscription,
        ]));

        $shopUuid = $this->getShopKeyId();

        $this->context->smarty->assign([
            'urlBilling' => 'https://unpkg.com/@prestashopcorp/billing-cdc/dist/bundle.js',
        ]);

        $output .= $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl') . $this->renderTabForm();

        return $output;
    }

    public function getShopKeyId()
    {
        $psService = \Module::getInstanceByName('ps_accounts')
            ->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

        if (method_exists($psService, 'getShopUuid')) {
            return $psService->getShopUuid();
        }

        return $psService->getShopUuidV4();
    }

    protected function checkItemFields()
    {
        $errors = [];

        if (Tools::isEmpty(Tools::getValue('BON_AI_TITLE_MAX'))) {
            $errors[] = $this->l('Max product title length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_TITLE_MAX'))) {
                $errors[] = $this->l('Bad max product title length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_SUMMARY_MAX'))) {
            $errors[] = $this->l('Max product summary length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_SUMMARY_MAX'))) {
                $errors[] = $this->l('Bad max product summary length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_PR_DESC_MAX'))) {
            $errors[] = $this->l('Max product description length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_PR_DESC_MAX'))) {
                $errors[] = $this->l('Bad max product description length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_PR_META_TITLE_MAX'))) {
            $errors[] = $this->l('Max product meta title length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_PR_META_TITLE_MAX'))) {
                $errors[] = $this->l('Bad max product meta title length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_PR_META_DESC_MAX'))) {
            $errors[] = $this->l('Max product meta description length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_PR_META_DESC_MAX'))) {
                $errors[] = $this->l('Bad max product meta description length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_CAT_META_DESC_MAX'))) {
            $errors[] = $this->l('Max category meta description length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_CAT_META_DESC_MAX'))) {
                $errors[] = $this->l('Bad max category meta description length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_CAT_DESC_MAX'))) {
            $errors[] = $this->l('Max category description length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_CAT_DESC_MAX'))) {
                $errors[] = $this->l('Bad max category description length format');
            }
        }
        if (Tools::isEmpty(Tools::getValue('BON_AI_MARKETPLAC_DESC'))) {
            $errors[] = $this->l('Max product description for marketplace length is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BON_AI_MARKETPLAC_DESC'))) {
                $errors[] = $this->l('Bad max product description for marketplace length format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function renderTabForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product title length:'),
                        'name' => 'BON_AI_TITLE_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product summary length:'),
                        'name' => 'BON_AI_SUMMARY_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product description length:'),
                        'name' => 'BON_AI_PR_DESC_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product meta title length:'),
                        'name' => 'BON_AI_PR_META_TITLE_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product meta description length:'),
                        'name' => 'BON_AI_PR_META_DESC_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max category meta description length:'),
                        'name' => 'BON_AI_CAT_META_DESC_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max category description length:'),
                        'name' => 'BON_AI_CAT_DESC_MAX',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Max product description for marketplace length:'),
                        'name' => 'BON_AI_MARKETPLAC_DESC',
                        'col' => 2,
                        'suffix' => 'words',
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$fields_form]);
    }

    public function getConfigFieldsValues()
    {
        $fields = [];
        $configurations = $this->getConfigurations();

        foreach (array_keys($configurations) as $config) {
            $fields[$config] = Configuration::get($config);
        }

        return $fields;
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    public function getControllerName()
    {
        $controller_name = Tools::getValue('controller');

        return $controller_name;
    }

    public function hookDisplayBackOfficeHeader()
    {
        $controller_name = Tools::getValue('controller');
        $bonaicontent_hasSubscription = $this->hasSubscription ? 1 : 0;

        if ('AdminProducts' != $controller_name && 'AdminCategories' != $controller_name && Tools::getValue('configure') != $this->name) {
            return;
        }

        Media::addJsDefL('BonAIContentAjaxUrl', $this->context->link->getAdminLink('AdminAjaxBonAIContent'));
        Media::addJsDefL('controller_name', $controller_name);
        Media::addJsDefL('bonaicontent_hasSubscription', $bonaicontent_hasSubscription);
        $this->context->controller->addJquery();

        if ('AdminProducts' == $controller_name) {
            $this->context->controller->addJS($this->_path . 'views/js/bonaicontent_product.js');
        } elseif ('AdminCategories' == $controller_name) {
            $this->context->controller->addJS($this->_path . 'views/js/bonaicontent_category.js');
        }
        $this->context->controller->addCSS($this->_path . 'views/css/bonaicontent.css');
    }

    public function hookdisplayAdminProductsSeoStepBottom($params)
    {
        $iso_code = Context::getContext()->language->iso_code;
        $this->context->smarty->assign([
            'product_id' => $params['id_product'],
            'iso_code' => $iso_code,
        ]);

        return $this->fetch('module:bonaicontent/views/templates/hook/bonaicontent-product-seo.tpl');
    }

    public function hookdisplayAdminProductsMainStepLeftColumnMiddle($params)
    {
        $iso_code = Context::getContext()->language->iso_code;
        $this->context->smarty->assign([
            'product_id' => $params['id_product'],
            'iso_code' => $iso_code,
        ]);

        return $this->fetch('module:bonaicontent/views/templates/hook/bonaicontent-product.tpl');
    }

    public function hookdisplaybackOfficeCategory($params)
    {
        $iso_code = Context::getContext()->language->iso_code;
        $this->context->smarty->assign([
            'category_id' => $params['request']->get('categoryId'),
            'iso_code' => $iso_code,
        ]);

        return $this->fetch('module:bonaicontent/views/templates/hook/bonaicontent-category.tpl');
    }
}
