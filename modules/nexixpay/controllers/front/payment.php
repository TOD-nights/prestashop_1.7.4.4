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
 * @version     5.1.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;
use Nexi\XPay\Build\XPayBuild;
use Nexi\XPay\Redirect\Image;
use Nexi\XPay\Redirect\PagoDIL\Configuration as PagoDILConfiguration;
use Nexi\XPay\Redirect\XPay;

class NexiXPayPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $cart = $this->context->cart;

        if (!XPay::isCurrencySupported(CurrencyHelper::getCurrencyISOCode($cart->id_currency))) {
            \Tools::redirect('index.php?controller=order');
        }

        if (NexiXPay::isXPayBuild() && \Tools::getValue('selectedcard') == 'CC') {
            $xpayBuild = new XPayBuild($this->module);

            $dati = $xpayBuild->getFormDati($this->context, $cart);

            $template = 'payment_execution_16_emb.tpl';
        } else {
            $ret = $this->getRedirectDati($cart);

            if (!$ret['res']) {
                $this->redirectToErrorPage($this->module->l('Invalid selected payment method.', 'payment'));
            }

            $dati = $ret['dati'];
            $template = $ret['template'];
        }

        $this->context->smarty->assign($dati);

        if (!isset($template)) {
            $template = 'payment_execution_16.tpl';
        }

        $this->setTemplate(Helper::get_front_template_path($template));
    }

    private function getRedirectDati($cart)
    {
        $ret = [
            'res' => false,
            'dati' => [],
            'template' => 'payment_execution_16.tpl',
        ];

        $methods = XPay::getPaymentMethods();
        $imgLink = '';

        foreach ($methods as $method) {
            if ($method['type'] == 'CC') {
                $imgLink .= '<img class="methods" src="' . $method['image']
                    . '" height="20px" hspace="5" vspace="5" style="padding-top: 5px !important;
                padding-right: 10px !important; height:20px; !important">';
            }
        }

        foreach ($methods as $method) {
            if ($method['type'] != 'CC') {
                $imgLink .= '<img class="methods" src="' . $method['image']
                    . '" height="20px" hspace="5" vspace="5" style="padding-top: 5px !important;
                padding-right: 10px !important; height:20px !important;">';
            }
        }

        $nexiImage = new Image(
            Configuration::get('NEXIXPAY_AVAILABLE_METHODS'),
            Configuration::get('NEXIXPAY_LOGO_SMALL'),
            Configuration::get('NEXIXPAY_LOGO_LARGE'),
            Configuration::get('NEXIXPAY_ALIAS'),
            Configuration::get('NEXIXPAY_MAC'),
            $this->module->version,
            'prestashop',
            \Tools::substr(_PS_VERSION_, 0, 3) . '.x'
        );

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $imgLink = '';
            foreach ($methods as $method) {
                if ($method['type'] == 'CC') {
                    $imgLink .= '<img class="methods" src="' . $method['image']
                        . '" height="20px" hspace="5" vspace="5" style="padding-top: 5px !important;
                padding-right: 10px !important; height:20px; !important">';
                }
            }
        }

        $ret['dati'] = [
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int) $cart->id_currency),
            'total' => \Tools::displayPrice(Helper::getTotalFromCart($cart), new \Currency((int) $cart->id_currency)),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
            'nexi_logo' => $nexiImage->getLogoNexiWithParameters(),
            'selectedcard' => \Tools::getValue('selectedcard'),
        ];

        if (\Tools::getValue('selectedcard') == 'CC') {
            $ret['res'] = true;

            $ret['dati']['title'] = $this->module->l('Payment Cards', 'payment');
            $ret['dati']['description'] = $this->module->l('Pay securely by credit and debit card through Nexi.', 'payment');
            $ret['dati']['methods'] = $imgLink;

            return $ret;
        }

        foreach ($methods as $method) {
            if ($method->selectedcard != \Tools::getValue('selectedcard')) {
                continue;
            }

            $ret['res'] = true;

            $ret['dati']['title'] = $method->description;
            $ret['dati']['methods'] = '<img class="methods" src="' . $method->image . '" height="20px" hspace="5" vspace="5" style="padding-top: 5px !important; padding-right: 10px !important; height:20px !important;">';
            $ret['dati']['description'] = $this->module->l('Pay with', 'payment') . ' ' . $method->description . ' ' . $this->module->l('via Nexi XPay', 'payment');

            if ($method->selectedcard == 'PAGODIL') {
                $pagoDIL = new PagoDILConfiguration($this->module);

                $ret['dati']['pagoDILConfiguration'] = $pagoDIL->getConfiguration();
                $ret['dati']['installments'] = $pagoDIL->getArrayOfInstallmentValues();
                $ret['dati']['totalAmount'] = CurrencyHelper::getRoundedAmountXPay(
                    Helper::getTotalFromCart($cart),
                    CurrencyHelper::getCurrencyISOCode($cart->id_currency)
                );
                $ret['dati']['description'] = 'Pay in installments without interest with PagoDIL';

                $ret['template'] = 'pagodil_method_16.tpl';
            }

            break;
        }

        return $ret;
    }

    private function redirectToErrorPage($msg)
    {
        $this->context->smarty->assign([
            'error' => $msg,
        ]);

        $this->setTemplate(Helper::get_front_template_path('payment_error.tpl', 'payment_error_17.tpl'));
    }
}
