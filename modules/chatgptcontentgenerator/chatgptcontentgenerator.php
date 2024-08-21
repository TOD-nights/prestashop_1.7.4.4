<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Chatgptcontentgenerator\Api\Client as ApiClient;
use PrestaShop\Module\Chatgptcontentgenerator\Entity\GptContentGenerator as ContentGeneratorEntity;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

require_once 'vendor/autoload.php';

class Chatgptcontentgenerator extends Module
{
    protected $config_form = false;

    /**
     * @var ServiceContainer
     */
    private $container;

    /**
     * @var string
     */
    private $config_prefix;

    public function __construct()
    {
        $this->name = 'chatgptcontentgenerator';
        $this->tab = 'administration';
        $this->version = '1.0.6';
        $this->author = 'SoftSprint';
        $this->need_instance = 0;

        // Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
        $this->bootstrap = true;

        $this->module_key = '1f440eb08736d74b883b0e891da486d9';

        parent::__construct();

        $this->displayName = $this->l('ChatGPT Content Generator');
        $this->description = $this->l('ChatGPT Content Generator');

        $this->confirmUninstall = $this->l('Are you sure wand uninstall this module ?');

        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => '1.7.8.8'];

        if ($this->container === null) {
            $this->container = new \PrestaShop\Module\Chatgptcontentgenerator\Service\ServiceContainer(
                $this->name,
                $this->getLocalPath()
            );
        }

        $this->config_prefix = Tools::strtoupper($this->name) . '_';
    }

    public function install()
    {
        // CloudSync
        $moduleManager = ModuleManagerBuilder::getInstance()->build();

        if (!$moduleManager->isInstalled('ps_eventbus')) {
            $moduleManager->install('ps_eventbus');
        } elseif (!$moduleManager->isEnabled('ps_eventbus')) {
            $moduleManager->enable('ps_eventbus');
            $moduleManager->upgrade('ps_eventbus');
        } else {
            $moduleManager->upgrade('ps_eventbus');
        }

        $result = parent::install() &&
            $this->installSql() &&
            $this->getService('ps_accounts.installer')->install() &&
            $this->registerHook('actionAdminControllerSetMedia') &&
            $this->registerHook('actionAdminProductsListingFieldsModifier') &&
            $this->registerHook('actionAdminProductsListingResultsModifier') &&
            $this->registerHook('actionCategoryGridQueryBuilderModifier') &&
            $this->registerHook('actionCategoryGridDataModifier') &&
            $this->registerHook('actionCategoryGridDefinitionModifier');

        if ($result) {
            $this->installTabs(
                [
                    [
                        'visible' => true,
                        'class_name' => 'AdminChatGtpContentAjax',
                        'name' => $this->trans(
                            'ChatGPT Content Ajax',
                            [],
                            'Modules.Chatgptcontentgenerator.Admin'
                        ),
                        'id_parent' => -1,
                        'icon' => null,
                    ],
                ]
            );
        }

        return $result;
    }

    public function uninstall()
    {
        $result = parent::uninstall();

        if ($result) {
            $this->uninstallSql();

            $this->deleteConfig('SHOP_ASSOCIATED');
            $this->deleteConfig('SHOP_UID');
            $this->deleteConfig('SHOP_TOKEN');
            $this->deleteConfig('USE_PRODUCT_BRAND');
            $this->deleteConfig('USE_PRODUCT_CATEGORY');
        }

        return $result;
    }

    public function hookActionCategoryGridDefinitionModifier($params)
    {
        $request = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance()
            ->get('request_stack')->getMasterRequest();
        if (!$request || $request->attributes->get('_route') != 'admin_categories_search') {
            return;
        }

        if (Tools::isSubmit('filter_column_generated_description')) {
            if (trim(Tools::getValue('filter_column_generated_description')) !== '') {
                $this->context->cookie->filter_column_category_generated_description = (int) Tools::getValue(
                    'filter_column_generated_description'
                );
                $this->context->cookie->write();
            } else {
                unset($this->context->cookie->filter_column_category_generated_description);
                $this->context->cookie->write();
            }
        }
    }

    public function hookActionCategoryGridDataModifier($params)
    {
        $records = $params['data']->getRecords()->all();
        $records = (is_array($records) ? $records : []);
        $categories = array_map(
            function ($product) {
                return [
                    'id_category' => (int) $product['id_category'],
                    'generated_description' => (int) $product['generated_description'],
                ];
            },
            $records
        );

        Media::addJsDef([
            'catalogCategoriesList' => $categories,
            'columnGeneratedDescription' => isset($this->context->cookie->filter_column_category_generated_description)
                ? (int) $this->context->cookie->filter_column_category_generated_description
                : false,
        ]);
    }

    public function hookActionCategoryGridQueryBuilderModifier($params)
    {
        $params['search_query_builder']->leftJoin(
            'c',
            _DB_PREFIX_ . 'content_generator',
            'content_gen',
            'content_gen.`id_object` = c.`id_category` AND ' .
                    'content_gen.`object_type` = ' . ContentGeneratorEntity::TYPE_CATEGORY
        );
        $params['count_query_builder']->leftJoin(
            'c',
            _DB_PREFIX_ . 'content_generator',
            'content_gen',
            'content_gen.`id_object` = c.`id_category` AND ' .
                    'content_gen.`object_type` = ' . ContentGeneratorEntity::TYPE_CATEGORY
        );
        $params['search_query_builder']->addSelect('content_gen.id_content_generator AS generated_description');

        if (isset($this->context->cookie->filter_column_category_generated_description) &&
            $this->context->cookie->filter_column_category_generated_description !== '') {
            $params['search_query_builder']->andWhere(
                'IFNULL(content_gen.id_content_generator, 0)' .
                    ($this->context->cookie->filter_column_category_generated_description ? ' > 0' : ' = 0')
            );
            $params['count_query_builder']->andWhere(
                'IFNULL(content_gen.id_content_generator, 0)' .
                    ($this->context->cookie->filter_column_category_generated_description ? ' > 0' : ' = 0')
            );
        }
    }

    public function hookActionAdminProductsListingResultsModifier($params)
    {
        $products = (is_array($params['products']) ? $params['products'] : []);
        $products = array_map(
            function ($product) {
                return [
                    'id_product' => (int) $product['id_product'],
                    'generated_description' => (int) $product['generated_description'],
                ];
            },
            $products
        );

        Media::addJsDef([
            'catalogProductsList' => $products,
            'gptHomeCategory' => (int) Configuration::get('PS_HOME_CATEGORY'),
            'columnGeneratedDescription' => isset($this->context->cookie->filter_column_product_generated_description)
                ? (int) $this->context->cookie->filter_column_product_generated_description
                : false,
        ]);
    }

    public function hookActionAdminProductsListingFieldsModifier($params)
    {
        if (Tools::isSubmit('filter_column_generated_description')) {
            if (trim(Tools::getValue('filter_column_generated_description')) !== '') {
                $this->context->cookie->filter_column_product_generated_description = (int) Tools::getValue(
                    'filter_column_generated_description'
                );
            } else {
                unset($this->context->cookie->filter_column_product_generated_description);
            }
        }

        if (!isset($params['sql_where'])) {
            return;
        }

        if (!$params['sql_where'] || count($params['sql_where']) == 2) {
            $params['sql_table']['content_gen'] = [
                'table' => 'content_generator',
                'join' => 'LEFT JOIN',
                'on' => 'content_gen.`id_object` = p.`id_product` AND ' .
                    'content_gen.`object_type` = ' . ContentGeneratorEntity::TYPE_PRODUCT,
            ];

            $params['sql_select']['generated_description'] = [
                'table' => 'content_gen',
                'field' => 'id_content_generator',
            ];

            if (isset($this->context->cookie->filter_column_product_generated_description) &&
                $this->context->cookie->filter_column_product_generated_description !== '') {
                $params['sql_where'][] = ' IFNULL(content_gen.id_content_generator, 0)' .
                    ($this->context->cookie->filter_column_product_generated_description ? ' > 0 ' : ' = 0 ');
            }
        }
    }

    public function hookActionAdminControllerSetMedia()
    {
        if ($this->context->controller && $this->context->controller instanceof AdminModulesController) {
            $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.module.js');
            $this->context->controller->addCss($this->getPathUri() . 'views/css/back.css');
            return;
        }

        // get request instance (working only for the symphony controllers)
        $request = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance()
            ->get('request_stack')->getMasterRequest();

        if (!$request) {
            return;
        }

        $adminPageName = '';
        $buttonName = '';

        if ($request && $request->attributes->get('_route') == 'admin_product_catalog') {
            $adminPageName = 'productsList';
            $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.bulkactions.js');
        } elseif ($request && $request->attributes->get('_route') == 'admin_categories_index') {
            $adminPageName = 'categoriesList';
            $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.bulkactions.js');
        } elseif ($request && $request->attributes->get('_route') == 'admin_product_form') {
            $productId = (int) $request->attributes->get('id');

            if ($productId) {
                $adminPageName = 'productForm';
                $buttonName = $this->trans(
                    'Generate description',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                );

                Media::addJsDef([
                    'idProduct' => (int) $productId,
                ]);
            }
        } elseif ($request && $request->attributes->get('_route') == 'admin_categories_edit') {
            $categoryId = (int) $request->attributes->get('categoryId');
            if ($categoryId) {
                $adminPageName = 'categoryForm';
                $buttonName = $this->trans(
                    'Generate description',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                );

                Media::addJsDef([
                    'idCategory' => (int) $categoryId,
                ]);
            }
        } elseif ($request &&
            ($request->attributes->get('_route') == 'admin_cms_pages_edit' || $request->attributes->get('_route') == 'admin_cms_pages_create')) {
            $cmsId = (int) $request->attributes->get('cmsPageId');
            $adminPageName = 'cmsForm';
            $buttonName = $this->trans(
                'Generate content',
                [],
                'Modules.Chatgptcontentgenerator.Admin'
            );

            Media::addJsDef([
                'idCms' => (int) $cmsId,
            ]);
        }

        if ($adminPageName == '') {
            return;
        }

        try {
            $shopInfo = (new ApiClient($this->getConfigGlobal('SHOP_UID')))
                ->setToken($this->getConfigGlobal('SHOP_TOKEN'))
                ->getShopInfo()
            ;
        } catch (Exception $e) {
            return;
        }

        Media::addJsDef([
            'gptLanguages' => Language::getLanguages(),
            'gptAjaxUrl' => $this->context->link->getAdminLink('AdminChatGtpContentAjax'),
            'adminPageName' => $adminPageName,
            'gptShopInfo' => $shopInfo,

            'gptUseProductCategory' => (int) $this->getConfigGlobal('USE_PRODUCT_CATEGORY', null, 1),
            'gptUseProductBrand' => (int) $this->getConfigGlobal('USE_PRODUCT_BRAND', null, 1),

            'gptI18n' => [
                'yes' => $this->trans('Yes', [], 'Admin.Global'),
                'no' => $this->trans('No', [], 'Admin.Global'),
                'successMessage' => $this->trans(
                    'A text of %words% words was generated',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'maxLength' => $this->trans(
                    'Max length',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'buttonName' => $buttonName,
                'buttonRegenerate' => $this->trans('Regenerate', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'buttonTranslate' => $this->trans('Translate', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'buttonSend' => $this->trans('Send', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'buttonCancel' => $this->trans('Cancel', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'buttonClose' => $this->trans('Close', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'modalTitle' => $this->trans('Content', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'textCanceled' => $this->trans('Canceled', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'regenerateQuestion' => $this->trans(
                    'Are you sure want to regenerate this content?',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'translateQuestion' => $this->trans(
                    'Are you sure want to translate this content ? The current content will be lost',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'confirmCustomRequest' => $this->trans(
                    'Would you like to replace existing content?',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'customRequest' => $this->trans(
                    'Custom request to ChatGPT',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'words' => $this->trans('words', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'productTooltipMessage' => $this->trans(
                    'Please, select the main category and brand for the product to get a more accurate result.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'subscriptionNotAvaialable' => $this->trans(
                    'You need to order the subscription plan to use this feature.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'subscriptionPlanNoFeature' => $this->trans(
                    'Your current subscription plan does not allow you to use this feature! Please, order another plan',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'subscriptionLimitЕxceeded' => $this->trans(
                    'The subscription plan limit has been reached! Please, order another plan.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'bulkButtonName' => $this->trans('Generate description', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'bulkConfirmGenerateDescription' => $this->trans(
                    'Would you like to replace existing content?',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'bulkGeneratingDescription' => $this->trans(
                    'Generating description',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'bulkGenerationProcessFail' => $this->trans(
                    'Generating failed.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'bulkGenerationProcessCompleted' => $this->trans(
                    'The generation process has been completed.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
                'awaitingRequestResponse' => $this->trans(
                    'Your request has been added to the queue. Wait for completion and stay on the page.',
                    [],
                    'Modules.Chatgptcontentgenerator.Admin'
                ),
            ],
        ]);

        $this->context->controller->addCss($this->getPathUri() . 'views/css/admin.css');
        $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.js');
        $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.modal.js');
        $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.actions.js');
        $this->context->controller->addJs($this->getPathUri() . 'views/js/admin.custom.request.js');
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        // handle configuration form
        $this->postProcess();

        $moduleManager = ModuleManagerBuilder::getInstance()->build();

        /*********************
        * PrestaShop Account *
        * *******************/

        $accountsService = null;

        $accountsInstaller = $this->getService('ps_accounts.installer');
        // check the module PrestaShop Account is compatible with the module
        if ($accountsInstaller->checkModuleVersion() == false) {
            // init the module installer
            $modulesInstaller = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance()
                ->get('prestashop.module.manager');
            if (!$modulesInstaller) {
                $modulesInstaller = $moduleManager;
            }

            // try to install or upgrade the module "PrestaShop Account" automatically
            try {
                if (!$modulesInstaller->isInstalled('ps_accounts')) {
                    $modulesInstaller->install('ps_accounts');
                } elseif (!$modulesInstaller->isEnabled('ps_accounts')) {
                    $modulesInstaller->enable('ps_accounts');
                    $modulesInstaller->upgrade('ps_accounts');
                } else {
                    $modulesInstaller->upgrade('ps_accounts');
                }
                Tools::redirect(
                    $this->context->link->getAdminLink('AdminModules', true, [], ['configure' => $this->name])
                );
            } catch (\PrestaShop\PrestaShop\Core\Addon\Module\Exception\UnconfirmedModuleActionException $e) {
                $this->context->smarty->assign(
                    'error_message',
                    'Please upgrade the module PrestaShop Account to use the "' . $this->displayName . '"'
                );
                return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/errors.tpl');
            } catch (\PrestaShop\PsAccountsInstaller\Installer\Exception\InstallerException $e) {
                $this->context->smarty->assign('error_message', $e->getMessage());
                return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/errors.tpl');
            } catch (\Throwable $e) {
                $this->context->smarty->assign(
                    'error_message',
                    'Please upgrade the module "PrestaShop Account" to use the "' . $this->displayName . '"'
                );
                return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/errors.tpl');
            }
        }

        try {
            $accountsFacade = $this->getService('ps_accounts.facade');
            $accountsService = $accountsFacade->getPsAccountsService();
        } catch (\PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleVersionException $e) {
            $this->context->smarty->assign('error_message', $e->getMessage() . ' 2');
            return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/errors.tpl');
        } catch (\PrestaShop\PsAccountsInstaller\Installer\Exception\InstallerException $e) {
            $accountsInstaller = $this->getService('ps_accounts.installer');
            $accountsInstaller->install();
            $accountsFacade = $this->getService('ps_accounts.facade');
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
         * Shop sync consent  *
         * *******************/
        if ($moduleManager->isInstalled('ps_eventbus')) {
            $eventbusModule = Module::getInstanceByName('ps_eventbus');
            if (version_compare($eventbusModule->version, '1.9.0', '>=')) {
                $eventbusPresenterService = $eventbusModule
                    ->getService('PrestaShop\Module\PsEventbus\Service\PresenterService');

                $this->context->smarty->assign(
                    'urlCloudsync',
                    'https://assets.prestashop3.com/ext/cloudsync-merchant-sync-consent/latest/cloudsync-cdc.js'
                );

                $entitites = ['info', 'modules', 'themes', 'orders'];
                Media::addJsDef([
                    'contextPsEventbus' => $eventbusPresenterService->expose($this, $entitites),
                ]);
            }
        }

        /**********************
         * PrestaShop Billing *
         * *******************/

        // Load the context for PrestaShop Billing
        $billingFacade = $this->getService('ps_billings.facade');
        $partnerLogo = $this->getLocalPath() . 'logo.png';

        // PrestaShop Billing
        Media::addJsDef($billingFacade->present([
            'logo' => $partnerLogo,
            'tosLink' => 'https://saas.softsprint.net/terms-and-conditions-of-use.html',
            'privacyLink' => 'https://saas.softsprint.net/terms-and-conditions-of-use.html',
            'emailSupport' => 'support@softsprint.net',
        ]));

        $shopId = $this->getShopKeyId();

        $isShopAssociated = (bool) $this->getConfigGlobal('SHOP_ASSOCIATED');
        if ($isShopAssociated) {
            $isShopAssociated = $shopId == $this->getConfigGlobal('SHOP_UID');
        }

        // Retrieve the subscritpion for this module
        $subscription = $this->getService('ps_billings.service')->getCurrentSubscription();

        Media::addJsDef([
            'hasSubscription' => ($subscription && $subscription['success'] == true),
            'shopInfo' => false,
            'isShopAssociated' => $isShopAssociated,
            'backendEndpointUrl' => $this->context->link->getAdminLink('AdminChatGtpContentAjax'),
            'noRecordsText' => $this->trans('No records found', [], 'Modules.Chatgptcontentgenerator.Admin'),
        ]);

        $this->context->smarty->assign('urlBilling', 'https://unpkg.com/@prestashopcorp/billing-cdc/dist/bundle.js');

        return $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl') .
            $this->getConfigurationForm() .
            $this->renderStatisticsList() .
            $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.actions.tpl');
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

    private function renderStatisticsList()
    {
        $fields_list = [
            'name' => [
                'title' => $this->trans('Plan name', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'text',
            ],
            'productWords' => [
                'title' => $this->trans('Product words', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'text',
                'class' => 'text-center',
            ],
            'categoryWords' => [
                'title' => $this->trans('Category words', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'text',
                'class' => 'text-center',
            ],
            'pageWords' => [
                'title' => $this->trans('CMS page words', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'text',
                'class' => 'text-center',
            ],
            'customRequest' => [
                'title' => $this->trans('Allow custom requests', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'bool',
                'class' => 'text-center',
            ],
            'trialDays' => [
                'title' => $this->trans('Trial days', [], 'Modules.Chatgptcontentgenerator.Admin'),
                'type' => 'text',
                'class' => 'text-center',
            ],
        ];

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->no_link = true;
        $helper->actions = [];
        $helper->show_toolbar = true;
        $helper->toolbar_btn = [];
        $helper->module = $this;
        $helper->identifier = 'id_plan';
        $helper->title = $this->trans('Use of tariff features', [], 'Modules.Chatgptcontentgenerator.Admin');
        $helper->table = 'subscription-plan-used-limits';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        return $helper->generateList([], $fields_list);
    }

    public function getConfigurationForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->trans('General settings', [], 'Modules.Chatgptcontentgenerator.Admin'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->trans('Use product category', [], 'Modules.Chatgptcontentgenerator.Admin'),
                        'name' => $this->config_prefix . 'USE_PRODUCT_CATEGORY',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'USE_PRODUCT_CATEGORY_ON',
                                'value' => 1,
                                'label' => $this->trans('Yes', [], 'Admin.Global'),
                            ],
                            [
                                'id' => 'USE_PRODUCT_CATEGORY_OFF',
                                'value' => 0,
                                'label' => $this->trans('No', [], 'Admin.Global'),
                            ],
                        ],
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->trans('Use product brand', [], 'Modules.Chatgptcontentgenerator.Admin'),
                        'name' => $this->config_prefix . 'USE_PRODUCT_BRAND',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
                        'values' => [
                            [
                                'id' => 'USE_PRODUCT_BRAND_ON',
                                'value' => 1,
                                'label' => $this->trans('Yes', [], 'Admin.Global'),
                            ],
                            [
                                'id' => 'USE_PRODUCT_BRAND_OFF',
                                'value' => 0,
                                'label' => $this->trans('No', [], 'Admin.Global'),
                            ],
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->trans('Save', [], 'Admin.Global'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitConfigurations',
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = 'gpt_configuration';
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitConfigurations';
        $helper->currentIndex = $this->context->link->getAdminLink(
            'AdminModules',
            false,
            [],
            ['configure' => $this->name, 'tab_module' => $this->tab, 'module_name' => $this->name]
        );
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = [
            'fields_value' => [
                $this->config_prefix . 'USE_PRODUCT_CATEGORY' => $this->getConfigGlobal('USE_PRODUCT_CATEGORY', null, 1),
                $this->config_prefix . 'USE_PRODUCT_BRAND' => $this->getConfigGlobal('USE_PRODUCT_BRAND', null, 1),
            ],
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        ];

        return $helper->generateForm([$fields_form]);
    }

    private function postProcess()
    {
        if (Tools::isSubmit('submitConfigurations')) {
            $this->setConfigGlobal('USE_PRODUCT_CATEGORY', (int) $this->getValue('USE_PRODUCT_CATEGORY'));
            $this->setConfigGlobal('USE_PRODUCT_BRAND', (int) $this->getValue('USE_PRODUCT_BRAND'));

            $this->_confirmations[] = $this->trans('The settings has been updated successfully', [], 'Modules.Chatgptcontentgenerator.Admin');
        }
    }

    /**
     * Retrieve the service
     *
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName)
    {
        return $this->container->getService($serviceName);
    }

    /**
     * Install tabs for the admin panel
     */
    public function installTabs($tabs)
    {
        $install_success = true;
        $obj = new Tab();

        foreach ($tabs as $tab_config) {
            if ($obj->getIdFromClassName($tab_config['class_name'])) {
                continue;
            }

            $tab = new Tab();
            $tab->class_name = $tab_config['class_name'];
            $tab->active = isset($tab_config['visible']) ? $tab_config['visible'] : true;

            foreach (Language::getLanguages() as $lang) {
                $tab->name[$lang['id_lang']] = $tab_config['name'];
            }

            if (isset($tab_config['id_parent'])) {
                $tab->id_parent = (int) $tab_config['id_parent'];
            } else {
                $tab->id_parent = $obj->getIdFromClassName($tab_config['parent_class_name']);
            }

            $tab->module = $this->name;
            $tab->icon = isset($tab_config['icon']) ? $tab_config['icon'] : '';

            // clear permissions
            Db::getInstance()->execute(
                'DELETE FROM ' . _DB_PREFIX_ . 'authorization_role ' .
                'WHERE `slug` LIKE \'%' . pSql(strtoupper($tab_config['class_name'])) . '%\''
            );

            if (!$tab->add()) {
                $install_success = false;
            }
        }

        return $install_success;
    }

    public function jsonResponse($data = null)
    {
        if (is_array($data) || is_null($data)) {
            $data = array_merge(['success' => true], $data ?? []);
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function errorResponse($code = 500, $message = 'Error message default')
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => ['code' => $code, 'message' => $message],
        ]);
        exit;
    }

    public function jsonExeptionResponse(Exception $e)
    {
        return $this->errorResponse($e->getCode(), $e->getMessage());
    }

    /**
     *  @return bool
     */
    private function installSql()
    {
        if (!class_exists('SqlInstaller')) {
            require_once dirname(__FILE__) . '/sql/install-sql.php';
        }
        $sql = new SqlInstaller();
        if (!$sql->install()) {
            $this->_errors = $sql->getErrors();
            return false;
        }
        return true;
    }

    /**
     *  @return bool
     */
    private function uninstallSql()
    {
        // return true; // for debug only
        if (!class_exists('SqlInstaller')) {
            require_once dirname(__FILE__) . '/sql/install-sql.php';
        }
        $sql = new SqlInstaller();
        if (!$sql->uninstall()) {
            $this->_errors = $sql->getErrors();
            return false;
        }
        return true;
    }

    /**
     * @param string key
     * @param int id_lang
     * @param int id_shop_group
     * @param int id_shop
     * @param string html
     * @return mixed
     */
    public function getConfig($key, $id_lang = null, $id_shop_group = null, $id_shop = null, $default = false)
    {
        return Configuration::get($this->config_prefix . $key, $id_lang, $id_shop_group, $id_shop, $default);
    }

    public function getConfigGlobal($key, $idLang = null, $default = false)
    {
        return Configuration::get($this->config_prefix . $key, $idLang, 0, 0, $default);
    }

    /**
     * @param string key
     * @param mixed values
     * @param bool html
     * @param int id_shop_group
     * @param int id_shop
     * @return bool
     */
    public function setConfig($key, $values, $html = false, $id_shop_group = null, $id_shop = null)
    {
        return Configuration::updateValue($this->config_prefix . $key, $values, $html, $id_shop_group, $id_shop);
    }

    public function setConfigGlobal($key, $value, $html = false)
    {
        return Configuration::updateGlobalValue($this->config_prefix . $key, $value, $html);
    }

    /**
     * @param string key
     * @return bool
     */
    public function deleteConfig($key)
    {
        return Configuration::deleteByName($this->config_prefix . $key);
    }

    /**
     * @param string key
     * @param string default_value
     * @return bool
     */
    public function getValue($key, $default_value = false)
    {
        return Tools::getValue($this->config_prefix . $key, $default_value);
    }

    /**
     * @param string key
     * @param string default_value
     * @return bool
     */
    public function isSubmit($key)
    {
        return Tools::isSubmit($this->config_prefix . $key);
    }
}
