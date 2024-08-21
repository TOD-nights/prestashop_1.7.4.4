<?php
/**
 * Copyright (c) 2020 Nexi Payments S.p.A.
 *
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 *
 * @category    Payment Module
 *
 * @version     7.1.9
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'include/autoload.php';
require_once 'include/Utility/Helper.php';

define('XPAY_PLUGIN_VARIANT', 'xpay');
define('XPAY_MODULE_NAME', 'nexixpay');

class NexiXPay extends PaymentModule
{
    const NEXI_CONFIGURATION_FIELDS = [
        'NEXIXPAY_ENABLED_GATEWAY',
        'NEXIXPAY_ALIAS',
        'NEXIXPAY_MAC_KEY',
        'NEXINPG_API_KEY',
        'NEXIXPAY_ACCOUNTING',
        'NEXIXPAY_TEST',
        'NEXIXPAY_ENABLE_ONECLICK',
        'NEXIXPAY_ENABLE_3DSECURE',
        'NEXINPG_ENABLE_MULTICURRENCY',
        'NEXIXPAYBUILD_FONT_FAMILY',
        'NEXIXPAYBUILD_FONT_SIZE',
        'NEXIXPAYBUILD_FONT_STYLE',
        'NEXIXPAYBUILD_FONT_VARIANT',
        'NEXIXPAYBUILD_LETTER_SPACING',
        'NEXIXPAYBUILD_BORDER_COLOR_DEFAULT',
        'NEXIXPAYBUILD_BORDER_COLOR_ERROR',
        'NEXIXPAYBUILD_TEXT_COLOR_PLACEHOLDER',
        'NEXIXPAYBUILD_TEXT_COLOR_INPUT',
    ];

    const PAGODIL_CONFIGURATION_FIELDS = [
        'NEXIXPAY_PAGODIL',
        'NEXIXPAY_PAGODIL_PRODUCT_CODE',
        'NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES',
        'NEXIXPAY_PAGODIL_ENABLED_CATEGORIES',
        'NEXIXPAY_PAGODIL_TAX_CODE_VAR',
        'NEXIXPAY_PAGODIL_LINK',
        'NEXIXPAY_PAGODIL_PRODUCT_LIMIT',
        'NEXIXPAY_PAGODIL_SHOW_WIDGET',
        'NEXIXPAY_PAGODIL_INS_NUMBER',
        'NEXIXPAY_PAGODIL_LOGO_KIND',
    ];

    public function __construct()
    {
        $this->name = 'nexixpay';
        $this->tab = 'payments_gateways';
        $this->version = '7.1.9';
        $this->author = 'Nexi Payments SpA';
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->dependencies = [];
        $this->currencies = true;
        $this->currencies_mode = 'checkbox';
        $this->module_key = 'cfa2f3eb3553d9f7f2645df7556f9e62';
        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Nexi XPay');
        $this->description = $this->l('Payment module for payment cards and alternative methods. Powered by Nexi.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        $config = \Nexi\Redirect\Settings::getConfiguration();

        if (!isset($config['gateway']) || $config['gateway'] == '') {
            $gateway = 'xpay';

            if (isset($config['api_key']) && $config['api_key'] != '' && Configuration::get('NEXINPG_AVAILABLE_METHODS') != null) {
                $gateway = 'npg';
            }

            Configuration::updateValue('NEXIXPAY_ENABLED_GATEWAY', $gateway);
        }

        $this->registerHookIfNotRegistered();
    }

    public function install()
    {
        if (!self::isXPayRedirect() && !self::isXPayBuild()) {
            \Nexi\Utility\Logger::logExceptionCritical(new Exception('Invalid plugin variant'));
            $this->_errors[] = '<br/>Invalid plugin variant.';

            return false;
        }

        include_once dirname(__FILE__) . '/sql/install.php';
        include_once dirname(__FILE__) . '/include/install.php';

        if (
            !parent::install()
            || !$this->registerHook('actionAdminControllerSetMedia')
            || !$this->registerHook('actionFrontControllerSetMedia')
            || !$this->registerHook('displayAdminOrderMainBottom')
            || !$this->registerHook('paymentReturn')
            || !$this->registerHook('displayOrderConfirmation')
            || !$this->registerHook('paymentOptions')
            || !$this->registerHook('adminOrder')
            || !$this->registerHook('displayProductAdditionalInfo')
            || !$this->registerHook('displayProductPriceBlock')
            || !$this->registerHook('displayExpressCheckout')
            || !$this->registerHook('displayPaymentTop')
            || !$this->registerHook('displayCustomerAccount')
            || !$this->addOrderState($this->l('To be authorized'))
        ) {
            return false;
        }

        if (_PS_VERSION_ < 1.7 && (!$this->registerHook('displayPaymentEU') || !$this->registerHook('payment'))) {
            return false;
        }

        return true;
    }

    private function registerHookIfNotRegistered()
    {
        if (!static::isEnabled($this->name)) {
            return;
        }

        $hooksList = [
            'actionAdminControllerSetMedia',
            'actionFrontControllerSetMedia',
            'displayAdminOrderMainBottom',
            'displayOrderConfirmation',
            'displayProductAdditionalInfo',
            'displayProductPriceBlock',
            'displayExpressCheckout',
            'displayPaymentTop',
            'displayCustomerAccount',
        ];

        foreach ($hooksList as $hook) {
            if (!$this->isRegisteredInHook($hook)) {
                $this->registerHook($hook);
            }
        }

        if (version_compare(_PS_VERSION_, '1.7.7', '<')) {
            if (!$this->isRegisteredInHook('actionAdminOrdersListingFieldsModifier')) {
                $this->registerHook('actionAdminOrdersListingFieldsModifier');
            }
        } else {
            if (!$this->isRegisteredInHook('actionOrderGridDefinitionModifier')) {
                $this->registerHook('actionOrderGridDefinitionModifier');
            }
            if (!$this->isRegisteredInHook('actionOrderGridQueryBuilderModifier')) {
                $this->registerHook('actionOrderGridQueryBuilderModifier');
            }
        }

        $this->addOrderState($this->l('To be authorized'));
    }

    public function enable($forceAll = false)
    {
        if (!self::isXPayRedirect() && !self::isXPayBuild()) {
            \Nexi\Utility\Logger::logExceptionCritical(new Exception('Invalid plugin variant'));
            $this->_errors[] = '<br/>Invalid plugin variant.';

            return false;
        }

        return parent::enable();
    }

    public function uninstall()
    {
        include_once dirname(__FILE__) . '/sql/uninstall.php';
        include_once dirname(__FILE__) . '/include/uninstall.php';

        parent::uninstall();

        return true;
    }

    /**
     * displays module config form, it is also called after form submit
     *
     * @return mixed
     */
    public function getContent()
    {
        $output = '';

        if (\Tools::isSubmit('submit' . $this->name)) {
            // nexi XPay/NPG settings
            foreach (self::NEXI_CONFIGURATION_FIELDS as $field) {
                self::updateParam($field);
            }
            // pagodil settings
            foreach (self::PAGODIL_CONFIGURATION_FIELDS as $field) {
                self::updateParam($field);
            }

            if (\Nexi\Redirect\Settings::isGatewayNPG()) {
                $npg = new \Nexi\NPG\Redirect\NPG($this);

                $retG = $npg->checkApiKey();
            } elseif (\Nexi\Redirect\Settings::isGatewayXPay()) {
                $xpay = new \Nexi\XPay\Redirect\XPay($this);

                $retG = $xpay->checkConfigs();
            }

            $ret = ['res' => false, 'msg' => ''];

            if (isset($retG)) {
                $ret['res'] = $retG['res'];
                $ret['msg'] = $retG['msg'];
            }

            if ($ret['res']) {
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            } else {
                $output .= $this->displayError($this->l('Unable to save settings.') . ' ' . $ret['msg']);
            }
        }

        return $output . $this->getSettingForms();
    }

    private static function updateParam($param)
    {
        if ($param == 'NEXIXPAY_PAGODIL_ENABLED_CATEGORIES') {
            $value = \Tools::getValue($param);

            if (!is_array($value)) {
                $value = [];
            }

            $categories = json_encode($value);

            Configuration::updateValue($param, $categories);
        } else {
            if (\Tools::getValue($param) != null) {
                Configuration::updateValue($param, \Tools::getValue($param));
            }
        }
    }

    /**
     * builds Nexi XPay/NPG and PagoDIL settings form
     *
     * @return mixed
     */
    public function getSettingForms()
    {
        $formSettings = new \Nexi\Redirect\Settings($this);

        $form = $formSettings->getNexiXpayForm();

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->table = $this->table;
        $helper->name_controller = $this->name;
        $helper->token = \Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
        $helper->submit_action = 'submit' . $this->name;

        // Default language
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');

        // Load current value into the form
        foreach (self::NEXI_CONFIGURATION_FIELDS as $field) {
            $helper->fields_value[$field] = \Tools::getValue($field, Configuration::get($field));
        }

        $forms = [$this->name => $form];

        // if module variant is build then display also the style configuration form
        if (self::isXPayBuild()) {
            $forms['nexixpaybuild_style'] = $formSettings->getNexiXpayBuildForm($helper->fields_value);
        }

        // if the selected gateway is XPay check configuration for pagodil the display the form
        if (\Nexi\Redirect\Settings::isGatewayXPay() && \Nexi\XPay\Redirect\XPay::checkNexiConfigForPagoDIL()) {
            $pagoDIL = new \Nexi\XPay\Redirect\PagoDIL\Configuration($this);
            $pagoDILConfiguration = $pagoDIL->getConfiguration();

            // Load current value into the form
            foreach (self::PAGODIL_CONFIGURATION_FIELDS as $field) {
                $helper->fields_value[$field] = $pagoDILConfiguration[$field];
            }

            $cSign = \Nexi\Utility\CurrencyHelper::getCurrencySign('EUR');

            $helper->fields_value['NEXIXPAY_PAGODIL_MIN_CART'] = \Nexi\Utility\CurrencyHelper::fromMinUnitToAmountXPay(\Tools::ps_round($pagoDILConfiguration['NEXIXPAY_PAGODIL_MIN_CART'], 2), 'EUR') . $cSign;
            $helper->fields_value['NEXIXPAY_PAGODIL_MAX_CART'] = \Nexi\Utility\CurrencyHelper::fromMinUnitToAmountXPay(\Tools::ps_round($pagoDILConfiguration['NEXIXPAY_PAGODIL_MAX_CART'], 2), 'EUR') . $cSign;

            $helper->fields_value['NEXIXPAY_PAGODIL_POSSIBLE_INS_VALUES'] = implode(', ', $pagoDIL->getArrayOfInstallmentValues());

            $forms['nexixpay_pagodil'] = $formSettings->getPagoDILForm($helper->fields_value);
        }

        return $helper->generateForm($forms);
    }

    /**
     * payment methods hook for 1.7 PS version
     *
     * @param mixed $params
     *
     * @return array
     */
    public function hookPaymentOptions($params)
    {
        $payment_options = [];

        if (!$this->active) {
            return $payment_options;
        }

        if (\Nexi\NPG\Redirect\NPG::canPay()) {
            if (self::isXPayBuild()) {
                $npgBuild = new \Nexi\NPG\Build\NPGBuild($this);

                $payment_options = array_merge($payment_options, $npgBuild->getAPM($this->context));
            } else {
                $npg = new \Nexi\NPG\Redirect\NPG($this);

                $payment_options = array_merge($payment_options, $npg->getAPM($this->context));
            }
        } elseif (\Nexi\XPay\Redirect\XPay::canPay()) {
            if (!static::checkXPayCurrency($params['cart'])) {
                return $payment_options;
            }

            if (self::isXPayBuild()) {
                $xpayBuild = new \Nexi\XPay\Build\XPayBuild($this);

                $payment_options = array_merge($payment_options, $xpayBuild->getAPM($this->context, $this->context->cart));
            } else {
                $xpay = new \Nexi\XPay\Redirect\XPay($this);

                $payment_options = array_merge($payment_options, $xpay->getAPM($params['cart']));
            }
        }

        foreach ($payment_options as $options) {
            if (!(is_object($options) && $options instanceof PrestaShop\PrestaShop\Core\Payment\PaymentOption)) {
                \Nexi\Utility\Logger::log('Error in creation of payment options', 3);

                return [];
            }
        }

        return $payment_options;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function hookDisplayPaymentEU($params)
    {
        if (!$this->active) {
            return;
        }

        if (!static::checkXPayCurrency($params['cart'])) {
            return;
        }

        $oImg = new \Nexi\XPay\Redirect\Image(
            Configuration::get('NEXIXPAY_AVAILABLE_METHODS'),
            Configuration::get('NEXIXPAY_LOGO_SMALL'),
            Configuration::get('NEXIXPAY_LOGO_LARGE'),
            Configuration::get('NEXIXPAY_ALIAS'),
            Configuration::get('NEXIXPAY_MAC'),
            $this->version,
            'prestashop',
            \Tools::substr(_PS_VERSION_, 0, 3) . '.x'
        );

        return [
            'cta_text' => $this->l('Payment Cards'),
            'logo' => $oImg->getLogoNexiWithParameters(),
            'form' => $this->context->smarty->fetch(\Nexi\Utility\Helper::get_front_template_path('payment_execution.tpl')),
        ];
    }

    /**
     * payment methods hook for 1.6 PS version
     *
     * @param mixed $params
     *
     * @return mixed
     */
    public function hookPayment($params)
    {
        if (!$this->active) {
            return;
        }

        $cart = $params['cart'];

        if (!static::checkXPayCurrency($cart)) {
            return;
        }

        $currency = \Nexi\Utility\CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        if ($currency == 'EUR' && \Nexi\NPG\Redirect\NPG::canPay()) {
            $dati = [
                'paymentGateway' => PG_NPG,
                'title' => $this->l('Payment Cards'),
                'description' => $this->l('Pay securely by credit, debit and prepaid card. Powered by Nexi.'),
                'this_path' => $this->_path,
                'this_path_bw' => $this->_path,
                'this_path_ssl' => \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
                'psVersion' => _PS_VERSION_,
                'divisa' => $currency,
            ];
        } elseif (\Nexi\XPay\Redirect\XPay::canPay()) {
            $xpay = new \Nexi\XPay\Redirect\XPay($this);

            $methods = $xpay->getAPM_legacy($cart);

            $oImg = new \Nexi\XPay\Redirect\Image(
                Configuration::get('NEXIXPAY_AVAILABLE_METHODS'),
                Configuration::get('NEXIXPAY_LOGO_SMALL'),
                Configuration::get('NEXIXPAY_LOGO_LARGE'),
                Configuration::get('NEXIXPAY_ALIAS'),
                Configuration::get('NEXIXPAY_MAC'),
                $this->version,
                'prestashop',
                \Tools::substr(_PS_VERSION_, 0, 3) . '.x'
            );

            $dati = [
                'paymentGateway' => PG_XPAY,
                'title' => $this->l('Payment Cards'),
                'description' => $this->l('Pay securely by credit, debit and prepaid card. Powered by Nexi.'),
                'this_path' => $this->_path,
                'this_path_bw' => $this->_path,
                'this_path_ssl' => \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
                'nexi_logo' => $oImg->getLogoNexiWithParameters(),
                'methods' => $methods,
                'psVersion' => _PS_VERSION_,
                'divisa' => $currency,
            ];
        }

        $this->smarty->assign($dati);

        return $this->display(__FILE__, 'payment.tpl');
    }

    public function hookPaymentReturn($params)
    {
        if (!$this->active) {
            return;
        }

        if (_PS_VERSION_ < 1.7) {
            $oOrder = $params['objOrder'];
        } else {
            $oOrder = $params['order'];
        }

        $state = $oOrder->getCurrentState();

        $possibleStates = [
            Configuration::get('PS_OS_PAYMENT'),
            Configuration::get('PS_OS_OUTOFSTOCK'),
            Configuration::get('PS_OS_OUTOFSTOCK_UNPAID'),
        ];

        if (\Nexi\Redirect\Settings::isGatewayXPay()) {
            $possibleStates[] = $this->getXpayPendingPaymentStatus();
        }

        if (in_array($state, $possibleStates)) {
            return;
        }

        $this->smarty->assign('status', 'failed');

        return $this->display(__FILE__, 'payment_return.tpl');
    }

    /**
     * hook to display order details - frontoffice
     *
     * @param array $params
     *
     * @return void
     */
    public function hookDisplayOrderConfirmation($params)
    {
        if (!$this->active) {
            return;
        }

        if (_PS_VERSION_ < 1.7) {
            $oOrder = $params['objOrder'];
        } else {
            $oOrder = $params['order'];
        }

        $state = $oOrder->getCurrentState();

        $possibleStates = [
            Configuration::get('PS_OS_PAYMENT'),
            Configuration::get('PS_OS_OUTOFSTOCK'),
            Configuration::get('PS_OS_OUTOFSTOCK_UNPAID'),
        ];

        if (\Nexi\Redirect\Settings::isGatewayXPay()) {
            $possibleStates[] = $this->getXpayPendingPaymentStatus();
        }

        if (!in_array($state, $possibleStates)) {
            return;
        }

        $this->smarty->assign([
            'status' => 'ok',
            'id_order' => $oOrder->id,
            'shop_name' => Configuration::get('PS_SHOP_NAME'),
        ]);

        if (isset($oOrder->reference) && !empty($oOrder->reference)) {
            $this->smarty->assign('reference', $oOrder->reference);
        }

        return $this->display(__FILE__, 'payment_return.tpl');
    }

    /**
     * hook to display payment information and possible actions (account/refund) in order detail - BackOffice
     * ps_version < 1.7.7
     *
     * @param mixed $params
     *
     * @return mixed
     */
    public function hookAdminOrder($params)
    {
        if (!version_compare(_PS_VERSION_, '1.7.7', '<')) {
            return;
        }

        $ret = $this->getAdminOrderDetails($params['id_order']);

        if (!$ret['res']) {
            return;
        }

        $this->smarty->assign($ret['dati']);

        return $this->display(__FILE__, 'bo_payment_details.tpl');
    }

    /**
     * hook to display payment information and possible actions (account/refund) in order detail - BackOffice
     * ps_version >= 1.7.7
     *
     * @param array $params
     *
     * @return void|string
     */
    public function hookDisplayAdminOrderMainBottom($params)
    {
        if (!version_compare(_PS_VERSION_, '1.7.7', '>=')) {
            return;
        }

        $ret = $this->getAdminOrderDetails($params['id_order']);

        if (!$ret['res']) {
            return;
        }

        $this->smarty->assign($ret['dati']);

        return $this->display(__FILE__, 'bo_payment_details_177.tpl');
    }

    /**
     * checks if order is NPG or XPay and retrives all the data needed to display order detail and do actions on it
     *
     * @param int $orderId
     *
     * @return array
     */
    private function getAdminOrderDetails($orderId)
    {
        $ret = ['res' => false, 'dati' => []];

        $objOrder = new Order($orderId);

        if ($objOrder->module == $this->name) {
            if (\Nexi\NPG\Redirect\NPG::isOrder($objOrder->id_cart)) {
                $npg = new \Nexi\NPG\Redirect\NPG($this);

                $ret = $npg->getBoDetails($objOrder);

                $ret['dati']['paymentGateway'] = PG_NPG;
            } else {
                $xpay = new \Nexi\XPay\Redirect\XPay($this);

                $ret = $xpay->getBoDetails($objOrder);

                $ret['dati']['paymentGateway'] = PG_XPAY;
            }

            $controller_xpay = 'AdminNexiXPay';
            $controller_xpay_url = $this->context->link->getAdminLink($controller_xpay);

            $ret['dati']['controller_xpay'] = $controller_xpay;
            $ret['dati']['controller_xpay_url'] = $controller_xpay_url;
            $ret['dati']['id_order'] = $objOrder->id;
            $ret['dati']['module_templates'] = dirname(__FILE__) . '/views/templates/';
        }

        return $ret;
    }

    public function hookActionAdminControllerSetMedia()
    {
        if (
            get_class($this->context->controller) == 'AdminOrdersController'
            || get_class($this->context->controller) == 'AdminLegacyLayoutControllerCore'
            || get_class($this->context->controller) == 'AdminModulesController'
        ) {
            $this->context->controller->addJS($this->_path . 'views/js/xpay_admin.js?v=' . $this->version, false);
            $this->context->controller->addCSS($this->_path . 'views/css/back.css?v=' . $this->version, 'all', null, false);
        }
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        $this->context->controller->addJS($this->_path . 'views/js/front_xpay.js');
        $this->context->controller->addJS($this->_path . 'views/js/pagodil-sticker.min.js');
        $this->context->controller->addCSS($this->_path . 'views/css/front.css');

        if (\Nexi\Redirect\Settings::isGatewayNPG() && self::isXPayBuild()) {
            $this->context->controller->addJS($this->_path . 'views/js/npg_build.js');
        }

        // check if we are in order page
        if ($this->context->controller->php_self == 'order' && version_compare(_PS_VERSION_, '1.7', '>=')) {
            $this->context->controller->addJS('/modules/' . $this->name . '/views/js/xpay_contract.js');

            if (\Nexi\Redirect\Settings::isGatewayXPay() && self::isXPayBuild()) {
                $this->context->controller->addJS('/modules/' . $this->name . '/views/js/xpay_build.js');
            }
        }
    }

    /**
     * adds additional info in product detail page - FrontOffice
     */
    public function hookDisplayProductAdditionalInfo()
    {
        if (!\Nexi\XPay\Redirect\XPay::canPay()) {
            return;
        }

        $pagoDIL = new \Nexi\XPay\Redirect\PagoDIL\Configuration($this);

        if ($pagoDIL->isPagoDILAvailable()) {
            $pagoDILConfiguration = $pagoDIL->getConfiguration();

            if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_SHOW_WIDGET']) {
                $productid = \Tools::getValue('id_product');

                if ($pagoDIL->checkProductCategories(['id_product' => $productid])) {
                    $this->smarty->assign('miniature', false);
                    $this->smarty->assign('checkout', false);
                    $this->smarty->assign('totAmount', self::calculateAmount(Product::getPriceStatic($productid)));
                    $this->smarty->assign('hideLogo', false);
                    $this->smarty->assign('modeBVariant', true);
                    $this->smarty->assign('pagoDILConfiguration', $pagoDILConfiguration);

                    echo $this->display(__FILE__, \Nexi\Utility\Helper::get_hook_template_display_path('addictionalInfo.tpl'));
                }
            }
        }
    }

    /**
     * adds information on product miniature in price section
     *
     * @param array|object $params
     */
    public function hookDisplayProductPriceBlock($params)
    {
        if (!\Nexi\XPay\Redirect\XPay::canPay()) {
            return;
        }

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            if ($params['type'] == 'after_price') {
                return $this->getPagoDilExtraInfo($params);
            }
        }

        if ($params['type'] == 'unit_price') {
            return $this->getPagoDilExtraInfo($params);
        }
    }

    private function getPagoDilExtraInfo($params)
    {
        $pagoDIL = new \Nexi\XPay\Redirect\PagoDIL\Configuration($this);

        if (!$pagoDIL->isPagoDILAvailable()) {
            return;
        }

        $pagoDILConfiguration = $pagoDIL->getConfiguration();

        if (!$pagoDILConfiguration['NEXIXPAY_PAGODIL_SHOW_WIDGET']) {
            return;
        }

        if (is_object($params['product'])) {
            if (!isset($params['product']->id)) {
                return;
            }

            $productid = $params['product']->id;
        } else {
            if (!array_key_exists('id', $params['product'])) {
                return;
            }

            $productid = $params['product']['id'];
        }

        $productTotal = self::calculateAmount(Product::getPriceStatic($productid));

        $pagoDIL->setAmount($productTotal);

        if ($pagoDIL->isAmountValid($productTotal)['res'] && $pagoDIL->checkProductCategories(['id_product' => $productid])) {
            $this->smarty->assign('productId', $productid);
            $this->smarty->assign('miniature', true);
            $this->smarty->assign('totAmount', $productTotal);
            $this->smarty->assign('hideLogo', true);
            $this->smarty->assign('pagoDILConfiguration', $pagoDILConfiguration);

            return $this->display(__FILE__, \Nexi\Utility\Helper::get_hook_template_display_path('addictionalInfo.tpl'));
        }
    }

    /**
     * shows widget below checkout button
     */
    public function hookDisplayExpressCheckout()
    {
        if (!\Nexi\XPay\Redirect\XPay::canPay()) {
            return;
        }

        $pagoDIL = new \Nexi\XPay\Redirect\PagoDIL\Configuration($this);

        if ($pagoDIL->isPagoDILAvailable()) {
            $pagoDILConfiguration = $pagoDIL->getConfiguration();

            if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_SHOW_WIDGET']) {
                $total = self::calculateAmount(
                    \Nexi\Utility\Helper::getTotalFromCart($this->context->cart),
                    \Nexi\Utility\CurrencyHelper::getCurrencyISOCode($this->context->cart->id_currency)
                );

                $pagoDIL->setCart($this->context->cart);
                $pagoDIL->setAmount($total);

                if ($pagoDIL->canPayWithPagoDIL()['res']) {
                    $this->smarty->assign('miniature', false);
                    $this->smarty->assign('checkout', true);
                    $this->smarty->assign('totAmount', $total);
                    $this->smarty->assign('hideLogo', false);
                    $this->smarty->assign('modeBVariant', true);
                    $this->smarty->assign('pagoDILConfiguration', $pagoDILConfiguration);

                    echo $this->display(__FILE__, \Nexi\Utility\Helper::get_hook_template_display_path('addictionalInfo.tpl'));
                }
            }
        }
    }

    /**
     * adds pending status if it does not exist
     *
     * @param mixed $name
     *
     * @return bool
     */
    public function addOrderState($name)
    {
        $state_exist = false;
        $states = OrderState::getOrderStates((int) $this->context->language->id);

        foreach ($states as $state) {
            if (in_array($name, $state)) {
                Configuration::updateValue('XPAY_PENDING_PAYMENT', $state['id_order_state']);
                $state_exist = true;
                break;
            }
        }

        if (!$state_exist) {
            $order_state = new OrderState();
            $order_state->color = '#00ffff';
            $order_state->send_email = false;
            $order_state->module_name = $this->name;
            $order_state->name = [];

            $languages = Language::getLanguages(false);

            foreach ($languages as $language) {
                $order_state->name[$language['id_lang']] = $name;
            }

            $order_state->add();

            Configuration::updateValue('XPAY_PENDING_PAYMENT', $order_state->id);
        }

        return true;
    }

    /**
     * hook above payment options, displays warning for PagoDIL
     */
    public function hookDisplayPaymentTop()
    {
        if (\Nexi\XPay\Redirect\XPay::canPay()) {
            $pagoDIL = new \Nexi\XPay\Redirect\PagoDIL\Configuration($this);

            if ($pagoDIL->isPagoDILAvailable()) {
                $pagoDIL->setCart($this->context->cart);
                $pagoDIL->setAmount(self::calculateAmount(
                    \Nexi\Utility\Helper::getTotalFromCart($this->context->cart),
                    \Nexi\Utility\CurrencyHelper::getCurrencyISOCode($this->context->cart->id_currency)
                ));

                $ret = $pagoDIL->canPayWithPagoDIL();

                if (!$ret['res'] && $ret['cat'] && !$ret['min']) {  // if profuct categories are valid but total amount is less than minimum
                    $pagoDILConfiguration = $pagoDIL->getConfiguration();

                    echo $this->displayWarning($this->l('Do you want to pay in convenient interest-free installments with PagoDIL by Cofidis? Reach the minimum value of') . ' ' . \Nexi\Utility\CurrencyHelper::formatAmountXPay($pagoDILConfiguration['NEXIXPAY_PAGODIL_MIN_CART'], 'EUR') . ' ' . $this->l('€ in the cart'));
                }
            }
        }
    }

    /**
     * hook to add new links in 'My accont' section, used to link to the saved payment cards' page
     *
     * @return void|string
     */
    public function hookDisplayCustomerAccount()
    {
        if (!\Nexi\NPG\Redirect\NPG::canPay() && !self::isXPayBuild()) {
            return;
        }

        $this->smarty->assign([
            'pageLink' => $this->context->link->getModuleLink($this->name, 'mycards'),
            'linkLabel' => $this->l('My Cards'),
            'v_less_1_7' => version_compare(_PS_VERSION_, '1.7', '>='),
        ]);

        return $this->display(__FILE__, 'custom_account_link.tpl');
    }

    /**
     * Modifies order table query and adds fields for the custom columns
     * only from ps_version 1.7.6
     * 
     * @param type $params
     */
    public function hookActionOrderGridQueryBuilderModifier($params)
    {
        if (\Nexi\Redirect\Settings::isGatewayNPG()) {
            return;
        }

        $searchQueryBuilder = $params['search_query_builder'];

        $searchQueryBuilder->addSelect('xpi.codTrans AS nexixpay_cod_trans');

        $searchQueryBuilder->leftJoin(
            'o',
            pSQL(_DB_PREFIX_) . 'xpay_payments_info',
            'xpi',
            'xpi.idCart = o.id_cart'
        );

        $filterValues = $params['search_criteria']->get('filters');

        if (array_key_exists('nexixpay_cod_trans', $filterValues)) {
            $value = trim($filterValues['nexixpay_cod_trans']);

            if (strlen($value)) {
                $searchQueryBuilder->andWhere('xpi.codTrans LIKE :nexixpay_cod_trans')
                ->setParameter('nexixpay_cod_trans', '%' . pSQL($value) . '%');
            }
        }
    }

    /**
     * Adds installment info columns to order table, fields previously added with query modifier
     * only from ps_version 1.7.6
     * 
     * @param type $params
     */
    public function hookActionOrderGridDefinitionModifier($params)
    {
        if (\Nexi\Redirect\Settings::isGatewayNPG()) {
            return;
        }

        $definition = $params['definition'];

        $dataColumn = new \PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn('nexixpay_cod_trans');
        $dataColumn->setName($this->l("XPay transaction"));
        $dataColumn->setOptions([
            'field' => 'nexixpay_cod_trans',
        ]);

        $columns = $definition->getColumns();

        $osnamePresent = false;
        $paymentPresent = false;
        foreach($columns->toArray() as $column) {
            if ($column['id'] === 'osname') {
                $osnamePresent = true;
            }

            if ($column['id'] === 'payment') {
                $paymentPresent = true;
            }
        }

        if ($osnamePresent) {
            $columns->addAfter('osname', $dataColumn);
        } elseif ($paymentPresent) {
            $columns->addAfter('payment', $dataColumn);
        } else {
            $columns->add($dataColumn);
        }

        $definition->getFilters()->add((new \PrestaShop\PrestaShop\Core\Grid\Filter\Filter('nexixpay_cod_trans', 'Symfony\Component\Form\Extension\Core\Type\TextType'))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => '',
                    ],
                ])
                ->setAssociatedColumn('nexixpay_cod_trans')
        );
    }

    public function getXpayPendingPaymentStatus()
    {
        if ($this->addOrderState($this->l('To be authorized'))) {
            return (int) Configuration::get('XPAY_PENDING_PAYMENT');
        }
    }

    public function getNewPaymentOption($title, $paymentLink, $logo, $moduleName, $addictionalInformation, $infoAsForm = false)
    {
        $newOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $newOption->setCallToActionText($title)
            ->setAction($paymentLink)
            ->setModuleName($moduleName);

        if ($logo != null) {
            $newOption->setLogo($logo);
        }

        if ($infoAsForm) {
            $newOption->setForm($addictionalInformation);
        } else {
            $newOption->setAdditionalInformation($addictionalInformation);
        }

        return $newOption;
    }

    private static function checkXPayCurrency($cart)
    {
        return \Nexi\XPay\Redirect\XPay::isCurrencySupported(\Nexi\Utility\CurrencyHelper::getCurrencyISOCode($cart->id_currency));
    }

    /**
     * @param float|string $amount
     *
     * @return string
     */
    private static function calculateAmount($amount, $currency = 'EUR')
    {
        return \Nexi\Utility\CurrencyHelper::calculateAmountToMinUnitXPay($amount, $currency);
    }

    /**
     * @param string $currency iso code
     *
     * @return string
     */
    public function getCurrencyLabel($currency)
    {
        $currencySign = [
            'EUR' => $this->l('Euros'),
            'CZK' => $this->l('Czech Kurun'),
            'PLN' => $this->l('Zloty'),
            'NZD' => $this->l('Dollars'),
            'AUD' => $this->l('Dollars'),
        ];

        return $currencySign[$currency];
    }

    public function disableModule()
    {
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            \Module::disableAllByName($this->name);
        } else {
            \Module::disableByName($this->name);
        }
    }

    public static function isXPayRedirect()
    {
        if (XPAY_PLUGIN_VARIANT == 'xpay') {
            return true;
        }

        return false;
    }

    public static function isXPayBuild()
    {
        if (XPAY_PLUGIN_VARIANT == 'xpay_build') {
            return true;
        }

        return false;
    }

    public function createModuleLink($module, $controller, $params = [], $ssl = null, $idLang = null, $idShop = null, $relativeProtocol = false)
    {
        return $this->context->link->getModuleLink($module, $controller, $params, $ssl, $idLang, $idShop, $relativeProtocol);
    }

    public function fetchTemplate($template, $dati)
    {
        $this->context->smarty->assign($dati);

        return $this->context->smarty->fetch($template);
    }

    public static function getShopFromCart($cart)
    {
        if ($cart instanceof \Cart) {
            return new \Shop($cart->id_shop);
        }

        return null;
    }

    public static function getShopFromCartId($cartId)
    {
        $cart = new \Order($cartId);

        return new \Shop($cart->id_shop);
    }

    public static function getShopFromOrder($order)
    {
        if ($order instanceof \Order) {
            return new \Shop($order->id_shop);
        }

        return null;
    }

    public static function getShopFromOrderId($orderId)
    {
        $order = new \Order($orderId);

        return new \Shop($order->id_shop);
    }
}
