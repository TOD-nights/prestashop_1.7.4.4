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
 * @version     5.3.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Settings;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;
use Nexi\XPay\Redirect\API;
use Nexi\XPay\Redirect\PagoDIL\Configuration as PagoDILConfiguration;
use Nexi\XPay\Redirect\PagoDIL\Payment as PagoDILPayment;
use Nexi\XPay\Redirect\Secure3d;
use Nexi\XPay\Redirect\XPay;

class NexiXPayPayModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    public function postProcess()
    {
        $cart = $this->context->cart;
        if (
            $cart->id_customer == 0 || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0 || !$this->module->active
        ) {
            \Tools::redirect('index.php?controller=order&step=1');
        }

        $authorized = false;
        foreach (\Module::getPaymentModules() as $module) {
            if ($module['name'] == $this->module->name) {
                $authorized = true;
                break;
            }
        }
        if (!$authorized) {
            exit($this->module->l('This payment method is not available.', 'pay'));
        }

        $customer = new \Customer($cart->id_customer);
        if (!\Validate::isLoadedObject($customer)) {
            \Tools::redirect('index.php?controller=order&step=1');
        }

        if (NexiXPay::isXPayBuild() && \Tools::getValue('xpayNonce')) {
            $this->xpayBuildPayment($customer);

            return;
        }

        if (\Tools::getValue('selectedcard') != 'PAGODIL') {
            $this->redirectPaymentPage($customer);

            return;
        }

        $pagoDIL = new PagoDILConfiguration($this->module);

        $pagoDIL->setNumberOfInstalments(\Tools::getValue('installments'));

        if (!$pagoDIL->isInstallmentValid()) {
            $this->redirectToErrorPage($this->module->l('Invalid number of installments', 'pay'));

            return;
        }

        $this->redirectPagoDILPaymentPage($customer);
    }

    private function redirectToErrorPage($msg)
    {
        $this->context->smarty->assign([
            'error' => $msg,
        ]);

        $this->setTemplate(Helper::get_front_template_path('payment_error.tpl', 'payment_error_17.tpl'));
    }

    private function redirectPaymentPage($customer)
    {
        $cart = $this->context->cart;

        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $param = $this->getParamsForm($cart->id, $customer);

        $this->context->smarty->assign('inputs', $param);
        $this->context->smarty->assign('url', $paymentGateway->urlCashPage);
        $this->context->smarty->assign('submit', $this->module->l('Pay via Nexi XPay', 'pay'));
        $this->context->smarty->assign('urlBack', $paymentGateway->urlBack);
        $this->context->smarty->assign('back', $this->module->l('Cancel order &amp; restore cart', 'pay'));
        $this->context->smarty->assign('message', $this->module->l('Thank you for your order. Now you\'ll be redirect to Nexi Payment Page.', 'pay'));

        $this->setTemplate(Helper::get_front_template_path('redirect.tpl'));
    }

    private function getBaseParams($order_id, $customer)
    {
        $cart = $this->context->cart;

        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $codTrans = $cart->id . '-' . time();

        $currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        $amount = CurrencyHelper::calculateAmountToMinUnitXPay(
            Helper::getTotalFromCart($cart),
            $currency
        );

        $Note2 = \Tools::substr(_PS_VERSION_, 0, 3) . '.x';
        $mod = Module::getInstanceByName($this->module->name);
        $Note3 = $mod->version;

        $params = [
            'alias' => $paymentGateway->apiKey,
            'importo' => $amount,
            'divisa' => $currency,
            'codTrans' => $codTrans,
            'nome' => $customer->firstname,
            'cognome' => $customer->lastname,
            'mail' => $customer->email,
            'url' => $paymentGateway->url,
            'url_back' => $paymentGateway->urlBack,
            'languageId' => Settings::getPaymentGatewayLanguage($this->context),
            'descrizione' => 'PS Order: ' . $order_id,
            'urlpost' => $paymentGateway->urlPost,
            'TCONTAB' => $paymentGateway->accounting,
            'Note1' => 'prestashop',
            'Note2' => $Note2,
            'Note3' => $Note3,
            'selectedcard' => \Validate::isString(\Tools::getValue('selectedcard')) ? \Tools::getValue('selectedcard') : null,
        ];

        if ($this->context->customer->isLogged() && \Configuration::get('NEXIXPAY_ENABLE_ONECLICK') == 1 && \Tools::getValue('selectedcard') == 'CC') {
            $md5_hash = md5($cart->id_customer . '@' . $this->context->customer->email . '@' . $paymentGateway->nexiUnique);

            $params['num_contratto'] = \Tools::substr('OC' . base_convert($md5_hash, 16, 36), 0, 30);
            $params['tipo_servizio'] = 'paga_1click';
            $params['gruppo'] = '';
            $params['codTrans'] = $cart->id . '-' . time();
            $params['mac'] = $this->getMacCalculatedOneClick($params);
        } else {
            $params['mac'] = $this->getMacCalculated($params);
        }

        return $params;
    }

    public function getParamsForm($order_id, $customer)
    {
        $params = $this->getBaseParams($order_id, $customer);

        $secure3d = new Secure3d($this->context->cart, $customer);

        if (\Configuration::get('NEXIXPAY_ENABLE_3DSECURE') == 1 && \Tools::getValue('selectedcard') == 'CC') {
            $params = array_merge($params, $secure3d->getParams3ds2());
        }

        return $params;
    }

    protected function getMacCalculatedOneClick($params)
    {
        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        return sha1('codTrans=' . $params['codTrans'] . 'divisa=' . $params['divisa']
            . 'importo=' . $params['importo'] . 'gruppo=' . $params['gruppo'] . 'num_contratto='
            . $params['num_contratto'] . $paymentGateway->privateKey);
    }

    protected function getMacCalculated($params)
    {
        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        return sha1('codTrans=' . $params['codTrans'] . 'divisa=' . $params['divisa']
            . 'importo=' . $params['importo'] . $paymentGateway->privateKey);
    }

    private function redirectPagoDILPaymentPage($customer)
    {
        $cart = $this->context->cart;

        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $param = $this->getPagoDILParamsForm($cart->id, $customer);

        $this->context->smarty->assign('inputs', $param);
        $this->context->smarty->assign('url', $paymentGateway->urlCashPage);
        $this->context->smarty->assign('submit', $this->module->l('Pay via Nexi XPay', 'pay'));
        $this->context->smarty->assign('urlBack', $paymentGateway->urlBack);
        $this->context->smarty->assign('back', $this->module->l('Cancel order &amp; restore cart', 'pay'));
        $this->context->smarty->assign('message', $this->module->l('Thank you for your order. Now you\'ll be redirect to Nexi Payment Page.', 'pay'));

        $this->setTemplate(Helper::get_front_template_path('redirect.tpl'));
    }

    public function getPagoDILParamsForm($order_id, $customer)
    {
        $params = $this->getBaseParams($order_id, $customer);

        $installments = \Tools::getValue('installments');

        $pagoDILPayment = new PagoDILPayment($this->module, $this->context->cart);

        $pagoDILPayment->setCustomer($customer);
        $pagoDILPayment->setNumberOfInstalments($installments);

        $params = array_merge($params, $pagoDILPayment->getParams());

        return $params;
    }

    /**
     * build payment, calls different functions with different endpoint by looking to the card setting:
     * - it's new and doesn't need to be saved
     * - it has to be saved
     * - it is already saved
     *
     * @param \Customer $customer
     *
     * @return void
     */
    private function xpayBuildPayment($customer)
    {
        $cart = $this->context->cart;

        $newCard = true;
        if (\Tools::getValue('contract')) {
            $newCard = \Tools::getValue('contract') == 'New';
        }

        $saveCard = false;
        if (\Tools::getValue('save_token')) {
            $saveCard = \Tools::getValue('save_token') == '1';
        }

        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();
        $numContratto = null;

        $mac = sha1('esito=' . \Tools::getValue('xpayEsito')
            . 'idOperazione=' . \Tools::getValue('xpayIdOperazione')
            . 'xpayNonce=' . \Tools::getValue('xpayNonce')
            . 'timeStamp=' . \Tools::getValue('xpayTimeStamp') . $paymentGateway->privateKey);

        if ($mac != \Tools::getValue('xpayMac')) {
            $this->savePaymentInfo(
                $cart,
                Tools::getValue('codiceTransazioneSelezionato'),
                'KO',
                CurrencyHelper::fromMinUnitToAmountXPay(
                    \Tools::getValue('importo'),
                    CurrencyHelper::getCurrencyISOCode($cart->id_currency)
                )
            );

            $this->redirectToErrorPage('Mac Error');

            return;
        }

        $oAPI = new API($paymentGateway->urlEnv, $paymentGateway->apiKey, $paymentGateway->privateKey);

        $nome = null;
        $cognome = null;
        $mail = null;

        if (!empty($customer->firstname)) {
            $nome = $customer->firstname;
        }

        if (!empty($customer->lastname)) {
            $cognome = $customer->lastname;
        }

        if (!empty($customer->email)) {
            $mail = $customer->email;
        }

        if ($newCard) {
            if ($saveCard) {
                $numContratto = XPayBuildContract::createNewToken($cart->id_customer);

                list($result, $response) = $oAPI->pagaNonceCreazioneContratto(
                    \Tools::getValue('codiceTransazioneSelezionato'),
                    \Tools::getValue('importo'),
                    CurrencyHelper::getCurrencyNumericIsoCode($cart->id_currency),
                    \Tools::getValue('xpayNonce'),
                    $numContratto,
                    $paymentGateway->accounting,
                    $nome,
                    $cognome,
                    $mail
                );

                // save card contract to customer
                if ($result) {
                    $this->saveContractInfo($cart->id_customer, $numContratto, $response['brand'], $response['pan'], \Tools::getValue('scadenza'));
                }
            } else {
                list($result, $response) = $oAPI->pagaNonceOneClickSubsequent(
                    \Tools::getValue('codiceTransazioneSelezionato'),
                    \Tools::getValue('importo'),
                    CurrencyHelper::getCurrencyNumericIsoCode($cart->id_currency),
                    \Tools::getValue('xpayNonce'),
                    $paymentGateway->accounting,
                    false,
                    $nome,
                    $cognome,
                    $mail
                );
            }
        } else {
            list($result, $response) = $oAPI->pagaNonceOneClickSubsequent(
                \Tools::getValue('codiceTransazioneSelezionato'),
                \Tools::getValue('importo'),
                CurrencyHelper::getCurrencyNumericIsoCode($cart->id_currency),
                \Tools::getValue('xpayNonce'),
                $paymentGateway->accounting,
                true,
                $nome,
                $cognome,
                $mail
            );
        }

        $importo = CurrencyHelper::fromMinUnitToAmountXPay(
            \Tools::getValue('importo'),
            CurrencyHelper::getCurrencyISOCode($cart->id_currency)
        );

        if (!$result) {
            $this->savePaymentInfo(
                $cart,
                \Tools::getValue('codiceTransazioneSelezionato'),
                $response['esito'],
                $importo
            );

            $this->redirectToErrorPage($response['errore']['messaggio']);

            return;
        }

        $this->module->validateOrder(
            $cart->id,
            Configuration::get('PS_OS_PAYMENT'),
            $importo,
            $this->module->displayName,
            null,
            ['transaction_id' => \Tools::getValue('codiceTransazioneSelezionato')],
            (int) $this->context->currency->id,
            false,
            $customer->secure_key
        );

        $this->savePaymentInfo(
            $cart,
            \Tools::getValue('codiceTransazioneSelezionato'),
            $response['esito'],
            $importo,
            \Tools::getValue('pan'),
            \Tools::getValue('scadenza'),
            $response['brand'],
            $response['data'] . ' ' . $response['ora'],
            $response['nazione'],
            $response['codiceAutorizzazione'],
            $numContratto,
            $nome,
            $cognome,
            $mail
        );

        \Tools::redirect('index.php?controller=order-confirmation'
            . '&id_cart=' . $cart->id
            . '&id_module=' . $this->module->id
            . '&id_order=' . $this->module->currentOrder
            . '&key=' . $customer->secure_key);
    }

    private function savePaymentInfo(
        $cart,
        $codTrans,
        $esito,
        $importo,
        $pan = null,
        $scadenza_pan = null,
        $brand = null,
        $data = null,
        $nazione = null,
        $codice_autorizzazione = null,
        $num_contratto = null,
        $nome = null,
        $cognome = null,
        $mail = null
    ) {
        $oPI = new PaymentInfo();

        $currency_order = new Currency($cart->id_currency);

        $oPI->codTrans = $codTrans;
        $oPI->idCart = $cart->id;
        $oPI->amount = $importo;
        $oPI->currency = $currency_order->iso_code;
        $oPI->brand = $brand;
        $oPI->result = $esito;
        $oPI->autCode = $codice_autorizzazione;
        $oPI->pan = $pan;
        $oPI->exp = $scadenza_pan;
        $oPI->nationality = $nazione;
        $oPI->contractNumber = $num_contratto;
        $oPI->firstName = $nome;
        $oPI->lastName = $cognome;
        $oPI->mail = $mail;

        $date = DateTime::createFromFormat('d/m/Y H:i:s', $data);

        if ($date === false) {
            $date = new DateTime();
        }

        $oPI->date = $date->format('Y-m-d H:i:s');

        $oPI->save();
    }

    private function saveContractInfo($idCustomer, $numContratto, $brand, $pan, $scadenzaPan)
    {
        $contract = new XPayBuildContract();

        $contract->id_customer = $idCustomer;
        $contract->num_contract = $numContratto;
        $contract->brand = $brand;
        $contract->pan = $pan;

        $oDate = DateTime::createFromFormat('Ym', $scadenzaPan);

        $contract->expiry_month = $oDate->format('m');
        $contract->expiry_year = $oDate->format('Y');

        $aContracts = $contract->getContracts($contract->id_customer);

        $save = true;
        if (is_array($aContracts)) {
            foreach ($aContracts as $contracts) {
                $pan = $contracts->pan;
                $expMonth = $contracts->expiry_month;
                $expYear = $contracts->expiry_year;
                $brand = $contracts->brand;

                if (
                    $pan != $contract->pan || $expMonth != $contract->expiry_month
                    || $expYear != $contract->expiry_year || $brand != $contract->brand
                ) {
                    continue;
                }

                $save = false;
                break;
            }
        }

        if ($save) {
            $contract->save();
        }
    }
}
