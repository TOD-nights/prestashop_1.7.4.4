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

namespace Nexi\XPay\Build;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Settings;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;
use Nexi\XPay\Redirect\Image;
use Nexi\XPay\Redirect\Secure3d;
use Nexi\XPay\Redirect\XPay;

class XPayBuild
{
    /**
     * @var \NexiXPay
     */
    private $module;

    public function __construct(\NexiXPay $module)
    {
        $this->module = $module;
    }

    public function getForm_1_7($context, $cart)
    {
        $dati = $this->getFormDati($context, $cart);

        return $this->module->getNewPaymentOption(
            $this->module->l('Payments cards'),
            $this->module->createModuleLink($this->module->name, 'payment', [], true),
            $dati['nexi_logo'],
            $this->module->name,
            $this->module->fetchTemplate(Helper::get_front_template_path('payment_execution_17_emb.tpl'), $dati),
            true
        );
    }

    public function getAPM($context, $cart)
    {
        $ampOptions = [];

        if (CurrencyHelper::getCurrencyISOCode($cart->id_currency) == 'EUR') {
            $ampOptions[] = $this->getForm_1_7($context, $cart);
        }

        $xpay = new XPay($this->module);

        return array_merge($ampOptions, $xpay->getAlternativeApmOptions($cart));
    }

    public function getFormDati($context, $cart)
    {
        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $oneClickEnabled = $context->customer->isLogged() ? $paymentGateway->enableOneclick : false;
        $contracts = $oneClickEnabled ? \XPayBuildContract::getContracts($cart->id_customer) : false;

        $aCvv = [];

        $codTransCvv = self::getCodTrans($cart->id);

        $importo = CurrencyHelper::calculateAmountToMinUnitXPay(
            Helper::getTotalFromCart($cart),
            CurrencyHelper::getCurrencyISOCode($cart->id_currency)
        );

        if ($oneClickEnabled) {
            if (isset($contracts) && is_array($contracts)) {
                foreach ($contracts as $contract) {
                    $codTransCvv = \Tools::substr($codTransCvv . '-' . uniqid(), 0, 30);
                    $aCvv['codiceTransazione-' . $contract->num_contract] = $codTransCvv;
                    $aCvv['timeStamp-' . $contract->num_contract] = time() * 1000;
                    $aCvv['mac-' . $contract->num_contract] = sha1('codTrans=' . $codTransCvv
                        . 'divisa=' . CurrencyHelper::getCurrencyNumericIsoCode($cart->id_currency)
                        . 'importo=' . $importo
                        . $paymentGateway->privateKey);
                }
            }
        }

        $oImg = new Image(
            \Configuration::get('NEXIXPAY_AVAILABLE_METHODS'),
            \Configuration::get('NEXIXPAY_LOGO_SMALL'),
            \Configuration::get('NEXIXPAY_LOGO_LARGE'),
            $paymentGateway->apiKey,
            $paymentGateway->privateKey,
            $this->module->version,
            'prestashop',
            \Tools::substr(_PS_VERSION_, 0, 3) . '.x'
        );

        $imageList = $oImg->getImgList('CC');

        $dati = [
            'title' => $this->module->l('Payments cards', 'xpaybuild'),
            'description' => $this->module->l('Pay securely by credit and debit card through Nexi.', 'xpaybuild'),
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int) $cart->id_currency),
            'total' => \Tools::displayPrice(
                Helper::getTotalFromCart($cart),
                new \Currency((int) $cart->id_currency)
            ),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
            'build' => array_merge($this->getBuildParams($context, $cart), $aCvv),
            'contracts' => $contracts,
            'oneClickEnabled' => $oneClickEnabled,
            'imageList' => $imageList,
            'nexi_logo' => $oImg->getLogoNexiWithParameters(),
        ];

        $secure3d = new Secure3d($cart, new \Customer($cart->id_customer));

        $dati['par3ds'] = $secure3d->getParams3ds2();
        $dati['nexixpaybuild_enabled3ds'] = \Configuration::get('NEXIXPAY_ENABLE_3DSECURE');

        $dati['errCode'] = null;
        $dati['msgError'] = null;

        if (\Tools::getValue('errCode') && \Tools::getValue('msgError')) {
            $dati['errCode'] = \Tools::getValue('errCode');
            $dati['msgError'] = \Tools::getValue('msgError');
        }

        return $dati;
    }

    private function getBuildParams($context, $cart)
    {
        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $importo = CurrencyHelper::calculateAmountToMinUnitXPay(
            Helper::getTotalFromCart($cart),
            CurrencyHelper::getCurrencyISOCode($cart->id_currency)
        );

        $params = [
            'apiKey' => $paymentGateway->apiKey,
            'importo' => $importo,
            'codiceTransazione' => self::getCodTrans($cart->id),
            'divisa' => CurrencyHelper::getCurrencyNumericIsoCode($cart->id_currency),
            'timeStamp' => self::getTimestamp(),
            'url' => $paymentGateway->url,
            'urlBack' => $paymentGateway->urlBack,
            'urlPost' => $paymentGateway->urlPost,
            'js_nexi_build' => $paymentGateway->urlEnv . 'ecomm/XPayBuild/js?alias=' . $paymentGateway->apiKey,
            'ambiente_js' => $paymentGateway->buildEnv,
            'languageId' => Settings::getPaymentGatewayLanguage($context),
            'styleConfiguration' => $this->getStyleConfiguration($paymentGateway),
            'borderColorDefault' => $paymentGateway->borderColorDefault,
            'borderColorError' => $paymentGateway->borderColorError,
        ];

        $strMac = 'codTrans=' . $params['codiceTransazione'] . 'divisa=' . $params['divisa'] . 'importo=' . $params['importo'] . $paymentGateway->privateKey;

        $params['mac'] = sha1($strMac);

        return $params;
    }

    public static function getCodTrans($cart_id, $payment_type = false)
    {
        $cod_trans = $cart_id . '-' . time();

        return \Tools::substr($cod_trans, 0, 30);
    }

    public static function getTimestamp()
    {
        return time() * 1000;
    }

    private function getStyleConfiguration($paymentGateway)
    {
        $styleConfiguration = [];

        if ($paymentGateway->fontSize) {
            $styleConfiguration['common']['fontSize'] = $paymentGateway->fontSize;
            $styleConfiguration['correct']['fontSize'] = $paymentGateway->fontSize;
            $styleConfiguration['error']['fontSize'] = $paymentGateway->fontSize;
        }

        if ($paymentGateway->fontFamily) {
            $styleConfiguration['common']['fontFamily'] = $paymentGateway->fontFamily;
            $styleConfiguration['correct']['fontFamily'] = $paymentGateway->fontFamily;
            $styleConfiguration['error']['fontFamily'] = $paymentGateway->fontFamily;
        }

        if ($paymentGateway->fontStyle) {
            $styleConfiguration['common']['fontStyle'] = $paymentGateway->fontStyle;
            $styleConfiguration['correct']['fontStyle'] = $paymentGateway->fontStyle;
            $styleConfiguration['error']['fontStyle'] = $paymentGateway->fontStyle;
        }

        if ($paymentGateway->fontVariant) {
            $styleConfiguration['common']['fontVariant'] = $paymentGateway->fontVariant;
            $styleConfiguration['correct']['fontVariant'] = $paymentGateway->fontVariant;
            $styleConfiguration['error']['fontVariant'] = $paymentGateway->fontVariant;
        }

        if ($paymentGateway->letterSpacing) {
            $styleConfiguration['common']['letterSpacing'] = $paymentGateway->letterSpacing;
            $styleConfiguration['correct']['letterSpacing'] = $paymentGateway->letterSpacing;
            $styleConfiguration['error']['letterSpacing'] = $paymentGateway->letterSpacing;
        }

        if ($paymentGateway->textColorPlaceholder) {
            $styleConfiguration['common']['::placeholder']['color'] = $paymentGateway->textColorPlaceholder;
            $styleConfiguration['correct']['::placeholder']['color'] = $paymentGateway->textColorPlaceholder;
            $styleConfiguration['error']['::placeholder']['color'] = $paymentGateway->textColorPlaceholder;
        }

        if ($paymentGateway->textColorInput) {
            $styleConfiguration['common']['color'] = $paymentGateway->textColorInput;
            $styleConfiguration['correct']['color'] = $paymentGateway->textColorInput;
            $styleConfiguration['error']['color'] = $paymentGateway->textColorInput;
        }

        return json_encode($styleConfiguration);
    }

    public static function canPayByContract($customer_id)
    {
        $contracts = \XPayBuildContract::getContracts($customer_id);

        if (\Configuration::get('NEXIXPAY_ENABLE_ONECLICK') && $contracts) {
            return $contracts;
        }

        return false;
    }
}
