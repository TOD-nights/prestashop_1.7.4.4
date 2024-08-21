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
 * @version     7.0.0
 */

namespace Nexi\XPay\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\NexiError;
use Nexi\Redirect\Settings;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;
use Nexi\Utility\Logger;
use Nexi\XPay\Redirect\PagoDIL\Configuration as PagoDILConfiguration;

class XPay
{
    /**
     * @var \NexiXPay
     */
    private $module;

    public function __construct($module)
    {
        $this->module = $module;
    }

    public static function getCredentials()
    {
        if (\Configuration::get('NEXIXPAY_MAC_KEY')) {
            $mac = \Tools::getValue('NEXIXPAY_MAC_KEY', \Configuration::get('NEXIXPAY_MAC_KEY'));
        }

        if (\Configuration::get('NEXIXPAY_ALIAS')) {
            $alias = \Tools::getValue('NEXIXPAY_ALIAS', \Configuration::get('NEXIXPAY_ALIAS'));
        }

        return [
            'mac' => isset($mac) ? $mac : null,
            'alias' => isset($alias) ? $alias : null,
        ];
    }

    public static function checkNexiConfigForPagoDIL()
    {
        $credentials = self::getCredentials();

        if ($credentials['mac'] !== null && $credentials['alias'] !== null) {
            $methods = self::getPaymentMethods();

            foreach ($methods as $method) {
                if ($method['code'] === 'PAGODIL') {
                    return true;
                }
            }
        }

        return false;
    }

    public static function getPaymentMethods()
    {
        if (\Configuration::get('NEXIXPAY_AVAILABLE_METHODS') == null) {
            return [];
        }

        $methods = \Tools::getValue('NEXIXPAY_AVAILABLE_METHODS', \Configuration::get('NEXIXPAY_AVAILABLE_METHODS'));

        if ($methods) {
            if (!is_array($methods)) {
                $methods = json_decode($methods, true);
            }
        } else {
            $methods = [];
        }

        return $methods;
    }

    /**
     * checks if XPay is configured correctly and is available
     *
     * @return bool
     */
    public static function canPay()
    {
        if (!Settings::isGatewayXPay()) {
            return false;
        }

        $credentials = self::getCredentials();

        if ($credentials['mac'] === null || $credentials['alias'] === null) {
            return false;
        }

        if (count(self::getPaymentMethods()) == 0) {
            return false;
        }

        return true;
    }

    public static function resetPaymentMethods()
    {
        \Configuration::updateValue('NEXIXPAY_AVAILABLE_METHODS', null);
    }

    public function checkConfigs()
    {
        $nexiSettingOk = ['res' => false, 'msg' => ''];

        try {
            $response = $this->getAvailableMethods();

            if (isset($response['availableMethods']) && $response['availableMethods'] != '' && is_array($response['availableMethods'])) {
                \Configuration::updateValue('NEXIXPAY_AVAILABLE_METHODS', json_encode($response['availableMethods']));
            } else {
                Logger::log('Availables Methods not found', 1);
            }

            if ((!isset($response['urlLogoNexiSmall']) || $response['urlLogoNexiSmall'] == '') && (!isset($response['urlLogoNexiLarge']) || $response['urlLogoNexiLarge'] == '')) {
                \Configuration::updateValue('NEXIXPAY_LOGO_SMALL', \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/img/logo.jpg');
                \Configuration::updateValue('NEXIXPAY_LOGO_LARGE', \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/img/logo.jpg');

                Logger::log('Nexi logo not found', 1);
            } else {
                if (\Validate::isString($response['urlLogoNexiSmall'])) {
                    \Configuration::updateValue('NEXIXPAY_LOGO_SMALL', $response['urlLogoNexiSmall']);
                }

                if (\Validate::isString($response['urlLogoNexiLarge'])) {
                    \Configuration::updateValue('NEXIXPAY_LOGO_LARGE', $response['urlLogoNexiLarge']);
                }
            }

            \Module::enableByName($this->module->name);

            $nexiSettingOk['res'] = true;
        } catch (NexiError $exc) {
            $this->module->disableModule();

            Logger::logExceptionWarning(new \Exception('error in save settings - ' . $exc->getMessage()));

            self::resetPaymentMethods();
        }

        $pagodilSettingOk = ['res' => true, 'msg' => ''];

        try {
            if ($nexiSettingOk['res']) {
                $pagoDIL = new PagoDILConfiguration($this->module);

                if ($pagoDIL->isPagoDILAvailable()) {
                    $pagoDIL->setNumberOfInstalments($pagoDIL->getConfiguration()['NEXIXPAY_PAGODIL_INS_NUMBER']);

                    if (!$pagoDIL->isInstallmentValid()) {
                        throw new \Exception($this->module->l('Invalid number of installments.', 'xpay'));
                    }
                }
            }
        } catch (\Exception $exc) {
            $pagodilSettingOk['res'] = false;
            $pagodilSettingOk['msg'] = $exc->getMessage();

            Logger::log('error in PagoDIL save settings - ' . $exc->getMessage(), 2);
        }

        if (!$nexiSettingOk['res'] || !$pagodilSettingOk['res']) {
            \Configuration::updateValue('NEXIXPAY_PAGODIL', 0);
        }

        $msg = '';

        if (!$nexiSettingOk['res'] || !$pagodilSettingOk['res']) {
            $tempMsg = $nexiSettingOk['msg'] != '' ? $nexiSettingOk['msg'] : '';
            $tempMsg .= $pagodilSettingOk['msg'] != '' ? $pagodilSettingOk['msg'] : '';

            $msg = $tempMsg;
        }

        return [
            'res' => $nexiSettingOk['res'] && $pagodilSettingOk['res'],
            'msg' => $msg,
        ];
    }

    private function getAvailableMethods()
    {
        $paymentGateway = $this->getConfiguration();

        $nxApi = new API($paymentGateway->urlEnv, $paymentGateway->apiKey, $paymentGateway->privateKey);

        $response = $nxApi->availableMethods('prestashop', \Tools::substr(_PS_VERSION_, 0, 3) . '.x', $this->module->version);

        return $response;
    }

    /**
     * @param \Shop|null $shop
     *
     * @return Parameters
     */
    public function getConfiguration($shop = null)
    {
        $paymentGateway = new Parameters();

        $config = Settings::getConfiguration($shop);

        if ($config['test_mode']) {
            $paymentGateway->urlEnv = $paymentGateway->urlIntegration;
            $paymentGateway->testMode = true;
            $paymentGateway->buildEnv = $paymentGateway->buildIntegrationEnv;
        } else {
            $paymentGateway->urlEnv = $paymentGateway->urlProduction;
            $paymentGateway->testMode = false;
            $paymentGateway->buildEnv = $paymentGateway->buildProductionEnv;
        }

        $paymentGateway->urlCashPage = $paymentGateway->urlEnv . 'ecomm/ecomm/DispatcherServlet';

        $paymentGateway->privateKey = $config['mac_key'];
        $paymentGateway->apiKey = $config['alias'];
        $paymentGateway->enableOneclick = $config['oneclick'];
        $paymentGateway->accounting = $config['accounting'];
        $paymentGateway->fontSize = $config['font_size'];
        $paymentGateway->fontFamily = $config['font_family'];
        $paymentGateway->fontStyle = $config['font_style'];
        $paymentGateway->fontVariant = $config['font_variant'];
        $paymentGateway->letterSpacing = $config['letter_spacing'];
        $paymentGateway->borderColorDefault = $config['border_color_default'];
        $paymentGateway->borderColorError = $config['border_color_error'];
        $paymentGateway->textColorPlaceholder = $config['text_color_placeholder'];
        $paymentGateway->textColorInput = $config['text_color_input'];

        $paymentGateway->nexiUnique = \Configuration::get('NEXIXPAY_UNIQUE');

        $paymentGateway->urlPost = $this->module->createModuleLink($this->module->name, 'S2S');
        $paymentGateway->urlBack = $this->module->createModuleLink($this->module->name, 'cancellation');
        $paymentGateway->url = $this->module->createModuleLink($this->module->name, 'ritorno');

        return $paymentGateway;
    }

    private function getAllowedAPMInfo($method)
    {
        return [
            'PAYPAL' => ['min_amount' => null],
            'SOFORT' => ['min_amount' => 10],
            'AMAZONPAY' => ['min_amount' => null],
            'GOOGLEPAY' => ['min_amount' => null],
            'APPLEPAY' => ['min_amount' => null],
            'ALIPAY' => ['min_amount' => null],
            'WECHATPAY' => ['min_amount' => null],
            'GIROPAY' => ['min_amount' => 10],
            'IDEAL' => ['min_amount' => 10],
            'BCMC' => ['min_amount' => null],
            'EPS' => ['min_amount' => 100],
            'P24' => ['min_amount' => null],
            'BANCOMATPAY' => ['min_amount' => null],
            'SCT' => ['min_amount' => null],
            'MASTERPASS' => ['min_amount' => null],
            'SKRILL' => ['min_amount' => null],
            'SKRILL1TAP' => ['min_amount' => null],
            'MULTIBANCO' => ['min_amount' => null],
            'MY_BANK' => ['min_amount' => null],
            'PAGODIL' => ['min_amount' => null],
            'PAYU' => ['min_amount' => 300],
            'BLIK' => ['min_amount' => 100],
            'POLI' => ['min_amount' => 100],
        ][$method];
    }

    private static function getAllowedAPMByCurrency()
    {
        return [
            'EUR' => [
                'PAYPAL',
                'SOFORT',
                'AMAZONPAY',
                'GOOGLEPAY',
                'APPLEPAY',
                'ALIPAY',
                'WECHATPAY',
                'GIROPAY',
                'IDEAL',
                'BCMC',
                'EPS',
                'P24',
                'BANCOMATPAY',
                'SCT',
                'MASTERPASS',
                'SKRILL',
                'SKRILL1TAP',
                'MULTIBANCO',
                'MY_BANK',
                'PAGODIL',
            ],
            'CZK' => ['PAYU'],
            'PLN' => ['PAYU', 'BLIK'],
            'NZD' => ['POLI'],
            'AUD' => ['POLI'],
        ];
    }

    public static function getSupportedCurrencies()
    {
        return array_keys(static::getAllowedAPMByCurrency());
    }

    public static function isCurrencySupported($currency)
    {
        return in_array($currency, static::getSupportedCurrencies());
    }

    private function getAPMByCurrency($currency)
    {
        return static::getAllowedAPMByCurrency()[$currency];
    }

    private function isCurrencyValidForApm($currency, $method)
    {
        return in_array($method, $this->getAPMByCurrency($currency));
    }

    private function isAmountValidForApm($amount, $currency, $method)
    {
        $amount = CurrencyHelper::calculateAmountToMinUnitXPay(
            $amount,
            $currency
        );

        $apm = $this->getAllowedAPMInfo($method);

        if ($apm['min_amount'] == null || $amount >= $apm['min_amount']) {
            return true;
        }

        return false;
    }

    private function canPayWithAPM($method, $amount, $currency)
    {
        return $this->isCurrencyValidForApm($currency, $method) && $this->isAmountValidForApm($amount, $currency, $method);
    }

    private function getForm($cart)
    {
        $oImg = new Image(
            \Configuration::get('NEXIXPAY_AVAILABLE_METHODS'),
            \Configuration::get('NEXIXPAY_LOGO_SMALL'),
            \Configuration::get('NEXIXPAY_LOGO_LARGE'),
            \Configuration::get('NEXIXPAY_ALIAS'),
            \Configuration::get('NEXIXPAY_MAC'),
            $this->module->version,
            'prestashop',
            \Tools::substr(_PS_VERSION_, 0, 3) . '.x'
        );

        $imageList = $oImg->getImgList('CC');

        $apmDati = [
            'title' => $this->module->l('Payments cards', 'xpay'),
            'description' => $this->module->l('Pay securely by credit, debit and prepaid card. Powered by Nexi.', 'xpay'),
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int) $cart->id_currency),
            'total' => \Tools::displayPrice(Helper::getTotalFromCart($cart), new \Currency((int) $cart->id_currency)),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
            'imageList' => $imageList,
            'NEXIXPAY_ENABLE_3DSECURE' => \Configuration::get('NEXIXPAY_ENABLE_3DSECURE'),
            'errCode' => null,
            'msgError' => null,
        ];

        if (
            (\Validate::isString(\Tools::getValue('errCode')) && \Tools::getValue('errCode'))
            && (\Validate::isString(\Tools::getValue('msgError')) && \Tools::getValue('msgError'))
        ) {
            $apmDati['errCode'] = \Tools::getValue('errCode');
            $apmDati['msgError'] = \Tools::getValue('msgError');
        }

        $templatePath = Helper::get_front_template_path('payment_execution.tpl');

        return $this->module->getNewPaymentOption(
            $this->module->l('Payments cards', 'xpay'),
            $this->module->createModuleLink($this->module->name, 'payment', [], true),
            $oImg->getLogoNexiWithParameters(),
            $this->module->name,
            $this->module->fetchTemplate($templatePath, $apmDati),
            true
        );
    }

    public function getAPM($cart)
    {
        $ampOptions = [];

        if (CurrencyHelper::getCurrencyISOCode($cart->id_currency) == 'EUR') {
            $ampOptions[] = $this->getForm($cart);
        }

        return array_merge($ampOptions, $this->getAlternativeApmOptions($cart));
    }

    public function getAlternativeApmOptions($cart)
    {
        $ampOptions = [];

        $availableMethods = self::getPaymentMethods();

        if (!is_array($availableMethods)) {
            return $ampOptions;
        }

        $apmDati = [];

        $total = Helper::getTotalFromCart($cart);
        $currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        foreach ($availableMethods as $am) {
            if ($am['type'] != 'APM') {
                continue;
            }

            $apmDati = [];

            if (!$this->canPayWithAPM($am['selectedcard'], $total, $currency)) {
                continue;
            }

            if ($am['selectedcard'] == 'PAGODIL') {
                $pagoDIL = new PagoDILConfiguration($this->module);

                $pagoDIL->setCart($cart);
                $pagoDIL->setAmount(CurrencyHelper::calculateAmountToMinUnitXPay($total, $currency));

                // if PagoDIL isn't enabled or cart isn't compatible with PagoDIL, jumps this method and a notice is displayed by hookDisplayPaymentTop
                if (!$pagoDIL->isPagoDILAvailable() || !$pagoDIL->canPayWithPagoDIL()['res']) {
                    continue;
                }

                $apmDati['pagoDILConfiguration'] = $pagoDIL->getConfiguration();
                $apmDati['installments'] = $pagoDIL->getArrayOfInstallmentValues($am);
                $apmDati['defaultInstallments'] = $pagoDIL->getDefaultInstallmentsValue();
                $apmDati['totalAmount'] = CurrencyHelper::getRoundedAmountXPay($total, $currency);

                $template = 'pagodil_method.tpl';
                $description = $this->module->l('Pay in installments without interest', 'xpay');
            } else {
                $template = 'alternative_methods.tpl';
                $description = $am['description'];
            }

            $apmDati['description'] = $this->module->l('Pay with', 'xpay') . ' ' . $am['description'] . ' ' . $this->module->l('via Nexi XPay', 'xpay');
            $apmDati['method'] = $am['description'];

            $addictionalInformation = $this->module->fetchTemplate(Helper::get_front_template_path($template), $apmDati);

            $ampOptions[] = $this->module->getNewPaymentOption(
                $description,
                $this->module->createModuleLink($this->module->name, 'pay', ['selectedcard' => $am['selectedcard']], true),
                $am['image'],
                $am['selectedcard'],
                $addictionalInformation,
                $am['selectedcard'] == 'PAGODIL'
            );
        }

        return $ampOptions;
    }

    public function getAPM_legacy($cart)
    {
        $methods = [];

        $availableMethods = self::getPaymentMethods();

        if (!is_array($availableMethods)) {
            return $methods;
        }

        $total = Helper::getTotalFromCart($cart);
        $currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        foreach ($availableMethods as $am) {
            if ($am['type'] != 'APM') {
                continue;
            }

            if (!$this->canPayWithAPM($am['selectedcard'], $total, $currency)) {
                continue;
            }

            if ($am['selectedcard'] == 'PAGODIL') {
                $pagoDIL = new PagoDILConfiguration($this->module);

                $pagoDIL->setCart($cart);
                $pagoDIL->setAmount(CurrencyHelper::calculateAmountToMinUnitXPay($total, $currency));

                // if PagoDIL isn't enabled or cart isn't compatible with PagoDIL, jumps this method and a notice is displayed by hookDisplayPaymentTop
                if (!$pagoDIL->isPagoDILAvailable() || !$pagoDIL->canPayWithPagoDIL()['res']) {
                    continue;
                }
            }

            $methods[] = (object) $am;
        }

        return $methods;
    }

    /**
     * due to upgrade errors 'xpay_payments_redirect' table was not renamed to 'xpay_payments_info' therefore in all the versions from 7.1.0 payment results are not saved on db
     * and the order details can't been shown
     *
     * this function restores the transaction details to the 'xpay_payments_info' table, if missing, before displaying the details
     *
     * @param \Order $order
     *
     * @return bool
     *
     * @since 7.1.6
     */
    private function restoreTransaction($order)
    {
        $paymentGateway = $this->getConfiguration(\NexiXPay::getShopFromOrder($order));

        $oAPI = new API(
            $paymentGateway->urlEnv,
            $paymentGateway->apiKey,
            $paymentGateway->privateKey
        );

        try {
            $orderPayment = \OrderPayment::getByOrderReference($order->reference);

            $codTrans = $orderPayment[0]->transaction_id;

            if (!$codTrans || $codTrans === '') {
                throw new \Exception('Invalid codTrans for order: ' . $order->id . ' - reference: ' . $order->reference);
            }

            $response = $oAPI->orderDetail($codTrans);

            $oPI = new \PaymentInfo();

            $oPI->codTrans = $codTrans;
            $oPI->idCart = $order->id_cart;

            if (array_key_exists('esito', $response)) {
                $oPI->result = $response['esito'];
            }

            if (array_key_exists('report', $response) && !empty($response['report'])) {
                if (isset($response['report'][0]['divisa'])) {
                    $oPI->currency = $response['report'][0]['divisa'];

                    if (isset($response['report'][0]['importo'])) {
                        $oPI->amount = CurrencyHelper::fromMinUnitToAmountXPay($response['report'][0]['importo'], $oPI->currency);
                    }
                }

                if (isset($response['report'][0]['brand'])) {
                    $oPI->brand = $response['report'][0]['brand'];
                }

                if (isset($response['report'][0]['dataTransazione'])) {
                    $oPI->date = $response['report'][0]['dataTransazione'];
                }

                if (isset($response['report'][0]['codiceAutorizzazione'])) {
                    $oPI->autCode = $response['report'][0]['codiceAutorizzazione'];
                }

                if (isset($response['report'][0]['pan'])) {
                    $oPI->pan = $response['report'][0]['pan'];
                }

                if (isset($response['report'][0]['scadenza'])) {
                    $oPI->exp = $response['report'][0]['scadenza'];
                }

                if (isset($response['report'][0]['nazione'])) {
                    $oPI->nationality = $response['report'][0]['nazione'];
                }

                if (array_key_exists('dettaglio', $response['report'][0]) && !empty($response['report'][0]['dettaglio'])) {
                    if (isset($response['report'][0]['dettaglio'][0]['nome'])) {
                        $oPI->firstName = $response['report'][0]['dettaglio'][0]['nome'];
                    }

                    if (isset($response['report'][0]['dettaglio'][0]['cognome'])) {
                        $oPI->lastName = $response['report'][0]['dettaglio'][0]['cognome'];
                    }

                    if (isset($response['report'][0]['dettaglio'][0]['mail'])) {
                        $oPI->mail = $response['report'][0]['dettaglio'][0]['mail'];
                    }
                }
            }

            if (!isset($oPI->amount) || !$oPI->amount) {
                $oPI->amount = $orderPayment[0]->amount;
            }

            if (!isset($oPI->currency) || !$oPI->currency) {
                $cart = new \Cart($order->id_cart);

                $oPI->currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);
            }

            $oPI->save();

            return true;
        } catch (\Exception $exc) {
            Logger::logExceptionWarning($exc);
        }

        return false;
    }

    /**
     * returns info on order and checks if an order can be refunded or payment accounted
     *
     * @param Order $order
     *
     * @return array
     */
    public function getBoDetails($order)
    {
        $ret = ['res' => false, 'dati' => []];

        $oPI = new \PaymentInfo();
        $payInfo = $oPI->getInfo($order->id_cart);

        if (!isset($payInfo['codTrans']) && $payInfo['codTrans'] == '') {
            if (!$this->restoreTransaction($order)) {
                return $ret;
            }

            $payInfo = $oPI->getInfo($order->id_cart);
        }

        $paymentGateway = $this->getConfiguration(\NexiXPay::getShopFromOrder($order));

        $oAPI = new API(
            $paymentGateway->urlEnv,
            $paymentGateway->apiKey,
            $paymentGateway->privateKey
        );

        try {
            $response = $oAPI->orderDetail($payInfo['codTrans']);
        } catch (NexiError $exc) {
            Logger::logExceptionWarning($exc);
        }

        $ret['dati']['aInfoBO'] = [];
        $ret['dati']['accountingOp'] = false;

        if (is_array($response) && count($response) > 0) {
            $ret['dati']['aInfoBO'] = $response;

            $payInfo['pan'] = $response['report'][0]['pan'];

            $ret['dati']['account'] = false;
            $ret['dati']['cancel'] = false;

            switch ($response['report'][0]['stato']) {
                case 'Contabilizzato':
                    $ret['dati']['accountingOp'] = true;
                    $ret['dati']['cancel'] = true;
                    $ret['dati']['accounting_op_text'] = $this->module->l('It is possible to make a partial or total cancellation.', 'xpay');
                    break;
                case 'Contabilizzato Parz.':
                    $ret['dati']['accountingOp'] = true;
                    $ret['dati']['account'] = true;
                    $ret['dati']['cancel'] = true;
                    $ret['dati']['accounting_op_text'] = $this->module->l('It is possible to perform the partial / total accounting / cancellation transactions.', 'xpay');
                    break;
                case 'Autorizzato':
                    $ret['dati']['accountingOp'] = true;
                    $ret['dati']['account'] = true;
                    $ret['dati']['cancel'] = true;
                    $ret['dati']['accounting_op_text'] = $this->module->l('It is possible to carry out the total or partial accounting, or the total cancellation of the transaction.', 'xpay');
                    break;
                case 'Rimborsato Parz.':
                    $ret['dati']['accountingOp'] = true;
                    $ret['dati']['cancel'] = true;
                    $ret['dati']['accounting_op_text'] = $this->module->l('A partial cancellation is possible.', 'xpay');
                    break;
                case 'In Corso':    // considre this case only if order is in panding state
                    if ($order->getCurrentState() == (int) \Configuration::get('XPAY_PENDING_PAYMENT')) {
                        $ret['dati']['accountingOp'] = true;
                        $ret['dati']['cancelTransaction'] = true;
                        $ret['dati']['accounting_op_text'] = $this->module->l('It is possible to cancel the transactions.', 'xpay');
                    }
                    break;
            }

            foreach ($ret['dati']['aInfoBO']['report'][0]['dettaglio'][0]['operazioni'] as $key => $operation) {
                $ret['dati']['aInfoBO']['report'][0]['dettaglio'][0]['operazioni'][$key]['importoFormatted'] = CurrencyHelper::formatAmountXPay($operation['importo'], $operation['divisa']);
            }

            if (isset($ret['dati']['aInfoBO']['report'][0]['importo'])) {
                $ret['dati']['aInfoBO']['fullImporto'] = CurrencyHelper::fromMinUnitToAmountXPay($ret['dati']['aInfoBO']['report'][0]['importo'], CurrencyHelper::getCurrencyISOCode($order->id_currency));
            }
        }

        $ret['dati']['payInfo'] = $payInfo;

        $currency = CurrencyHelper::getCurrencyISOCode($order->id_currency);

        $ret['dati']['currencySign'] = CurrencyHelper::getCurrencySign($currency);
        $ret['dati']['currencyLabel'] = $this->module->getCurrencyLabel($currency);

        $ret['res'] = true;

        return $ret;
    }

    /**
     * refunds the selected amount and changes order status
     *
     * @param int $id_order
     * @param float $importo
     *
     * @return array
     */
    public function refund($id_order, $importo)
    {
        $ret = ['res' => false, 'msg' => $this->module->l('Successful reversal operation', 'xpay')];

        $objOrder = new \Order($id_order);

        $paymentGateway = $this->getConfiguration(\NexiXPay::getShopFromOrder($objOrder));

        $objAPI = new API(
            $paymentGateway->urlEnv,
            $paymentGateway->apiKey,
            $paymentGateway->privateKey
        );

        $oPI = new \PaymentInfo();
        $payInfo = $oPI->getInfo($objOrder->id_cart);

        $amount = CurrencyHelper::calculateAmountToMinUnitXPay(
            $importo,
            CurrencyHelper::getCurrencyISOCode($objOrder->id_currency)
        );

        try {
            $objAPI->refund(
                $payInfo['codTrans'],
                $amount,
                CurrencyHelper::getCurrencyNumericIsoCode($objOrder->id_currency)
            );

            try {
                $orderDetails = $objAPI->orderDetail($payInfo['codTrans']);

                if (is_array($orderDetails) && count($orderDetails) > 0) {
                    if ($orderDetails['report'][0]['stato'] == 'Rimborsato') {
                        $objOrder->setCurrentState((int) \Configuration::get('PS_OS_REFUND'));
                    } elseif ($orderDetails['report'][0]['stato'] == 'Rimborsato Parz.' && $objOrder->getCurrentState() != (int) \Configuration::get('PS_CHECKOUT_STATE_PARTIAL_REFUND')) {
                        $objOrder->setCurrentState((int) \Configuration::get('PS_CHECKOUT_STATE_PARTIAL_REFUND'));
                    } elseif ($orderDetails['report'][0]['stato'] == 'Annullato') {
                        $objOrder->setCurrentState((int) \Configuration::get('PS_OS_CANCELED'));
                    }
                }
            } catch (NexiError $exc) {
                Logger::logExceptionWarning($exc);
            }
        } catch (NexiError $exc) {
            $ret['msg'] = $exc->getMessage();
        }

        return $ret;
    }

    /**
     * accounts the selected amount
     *
     * @param int $id_order
     * @param float $importo
     *
     * @return array
     */
    public function account($id_order, $importo)
    {
        $ret = ['res' => false, 'msg' => $this->module->l('Successful account operation', 'xpay')];
        $objOrder = new \Order($id_order);

        $paymentGateway = $this->getConfiguration(\NexiXPay::getShopFromOrder($objOrder));

        $objAPI = new API(
            $paymentGateway->urlEnv,
            $paymentGateway->apiKey,
            $paymentGateway->privateKey
        );

        $oPI = new \PaymentInfo();
        $payInfo = $oPI->getInfo($objOrder->id_cart);

        $amount = CurrencyHelper::calculateAmountToMinUnitXPay(
            $importo,
            CurrencyHelper::getCurrencyISOCode($objOrder->id_currency)
        );

        try {
            $objAPI->account(
                $payInfo['codTrans'],
                $amount,
                CurrencyHelper::getCurrencyNumericIsoCode($objOrder->id_currency)
            );
        } catch (NexiError $exc) {
            $ret['msg'] = $exc->getMessage();
        }

        return $ret;
    }
}
