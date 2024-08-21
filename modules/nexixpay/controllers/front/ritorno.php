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
 * @version     5.2.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Utility\Helper;
use Nexi\XPay\Redirect\Response;
use Nexi\XPay\Redirect\XPay;

class NexiXPayRitornoModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $rfo = new Response();
        $rfo->setPrivateKey($paymentGateway->privateKey);
        if (\Validate::isString(\Tools::getValue('alias'))) {
            $rfo->setApiKey(\Tools::getValue('alias'));
        }
        if (\Validate::isInt(\Tools::getValue('importo'))) {
            $rfo->setAmount(\Tools::getValue('importo'));
        }
        if (\Validate::isString(\Tools::getValue('divisa'))) {
            $rfo->setCurrency(\Tools::getValue('divisa'));
        }
        if (\Validate::isString(\Tools::getValue('codTrans'))) {
            $rfo->setCodTrans(\Tools::getValue('codTrans'));
        }
        if (\Validate::isString(\Tools::getValue('session_id'))) {
            $rfo->setSessionId(\Tools::getValue('session_id'));
        }
        if (\Validate::isString(\Tools::getValue('brand'))) {
            $rfo->setBrand(\Tools::getValue('brand'));
        }
        if (\Validate::isString(\Tools::getValue('nome'))) {
            $rfo->setFirstName(\Tools::getValue('nome'));
        }
        if (\Validate::isString(\Tools::getValue('cognome'))) {
            $rfo->setLastName(\Tools::getValue('cognome'));
        }
        if (\Validate::isString(\Tools::getValue('mail'))) {
            $rfo->setMail(\Tools::getValue('mail'));
        }
        if (\Validate::isString(\Tools::getValue('mac'))) {
            $rfo->setMac(\Tools::getValue('mac'));
        }
        if (\Validate::isString(\Tools::getValue('esito'))) {
            $rfo->setResult(\Tools::getValue('esito'));
        }
        if (\Validate::isString(\Tools::getValue('data'))) {
            $rfo->setDate(\Tools::getValue('data'));
        }
        if (\Validate::isString(\Tools::getValue('orario'))) {
            $rfo->setTime(\Tools::getValue('orario'));
        }
        if (\Validate::isString(\Tools::getValue('codAut'))) {
            $rfo->setCodAut(\Tools::getValue('codAut'));
        }
        if (\Validate::isString(\Tools::getValue('pan'))) {
            $rfo->setPan(\Tools::getValue('pan'));
        }
        if (\Validate::isString(\Tools::getValue('scadenza_pan'))) {
            $rfo->setExp(\Tools::getValue('scadenza_pan'));
        }
        if (\Validate::isString(\Tools::getValue('regione'))) {
            $rfo->setState(\Tools::getValue('regione'));
        }
        if (\Validate::isString(\Tools::getValue('nazionalita'))) {
            $rfo->setNationality(\Tools::getValue('nazionalita'));
        }
        if (\Validate::isString(\Tools::getValue('messaggio'))) {
            $rfo->setMessage(\Tools::getValue('messaggio'));
        }
        if (\Validate::isString(\Tools::getValue('hash'))) {
            $rfo->setHash(\Tools::getValue('hash'));
        }
        if (\Validate::isString(\Tools::getValue('check'))) {
            $rfo->setCheck(\Tools::getValue('check'));
        }
        if (\Validate::isString(\Tools::getValue('descrizione'))) {
            $rfo->setDescription(\Tools::getValue('descrizione'));
        }
        if (\Validate::isString(\Tools::getValue('languageId'))) {
            $rfo->setLanguageId(\Tools::getValue('languageId'));
        }

        $rfo->calculateMac();
        if ($rfo->responseVerified() && (\Tools::strtolower($rfo->getResult()) == 'ok' || \Tools::strtolower($rfo->getResult()) == 'pen')) {
            $arr_exploded = explode('-', $rfo->getCodTrans());

            if (count($arr_exploded) > 1) {
                $id_cart = $arr_exploded[0];
                $cart = new Cart($id_cart);
                $this->context->cart = $cart;

                if (
                    $cart->id_customer == 0 || $cart->id_address_delivery == 0
                    || $cart->id_address_invoice == 0 || !$this->module->active
                ) {
                    Tools::redirect('index.php?controller=order&step=1');
                }

                $customer = new Customer($cart->id_customer);
                if (!\Validate::isLoadedObject($customer)) {
                    Tools::redirect('index.php?controller=order&step=1');
                }

                $order = Order::getOrderByCartId((int) $cart->id);
                Tools::redirect(
                    'index.php?controller=order-confirmation&id_cart=' . $cart->id .
                        '&id_module=' . $this->module->id . '&id_order=' . $order .
                        '&key=' . $customer->secure_key
                );
            } else {
                $this->context->smarty->assign([
                    'error' => $this->module->l('Cart not found.', 'ritorno'),
                ]);
            }
        } else {
            $this->context->smarty->assign([
                'error' => $rfo->getMessage(),
            ]);

            $this->setTemplate(Helper::get_front_template_path('payment_error.tpl', 'payment_error_17.tpl'));
        }
    }
}
