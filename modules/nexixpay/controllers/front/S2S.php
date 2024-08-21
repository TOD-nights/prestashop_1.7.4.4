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

use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Logger;
use Nexi\XPay\Redirect\Response;
use Nexi\XPay\Redirect\XPay;

class NexiXPayS2SModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $this->display_column_left = false;

        $xpay = new XPay($this->module);
        $paymentGateway = $xpay->getConfiguration();

        $rfo = new Response();

        $rfo->setPrivateKey($paymentGateway->privateKey);
        if (\Validate::isString(\Tools::getValue('importo'))) {
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
        if (\Validate::isString(\Tools::getValue('codAut'))) {  // not valued if 'esito' = 'pen'
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

        $arr_exploded = explode('-', $rfo->getCodTrans());

        if (count($arr_exploded) > 1) {
            $id_cart = $arr_exploded[0];
            $cart = new Cart($id_cart);
            $this->context->cart = $cart;

            // checks if order already exists and if last payment result wasn't in pending the request cannot be processed
            if (Validate::isLoadedObject($this->context->cart) && $this->context->cart->OrderExists() == true) {
                $oPI = new PaymentInfo();
                $paymentInfo = $oPI->getInfo($id_cart);

                if (\Tools::strtolower($paymentInfo['result']) != 'pen') {
                    Logger::log('Order already exist', 4);
                    header('500 Internal Server Error', true, 500);
                    exit;
                }
            }

            if (
                $cart->id_customer == 0 || $cart->id_address_delivery == 0
                || $cart->id_address_invoice == 0 || !$this->module->active
            ) {
                Logger::log('missing customer data', 4);
                header('500 Internal Server Error', true, 500);
                exit;
            }

            $customer = new Customer($cart->id_customer);
            if (!Validate::isLoadedObject($customer)) {
                Logger::log('non-existent customer', 4);
                header('500 Internal Server Error', true, 500);
                exit;
            }
        } else {
            Logger::log('codTrans format not correct', 4);
            header('500 Internal Server Error', true, 500);
        }

        if ($rfo->responseVerified()) {
            if (\Tools::strtolower($rfo->getResult()) == 'ok' || \Tools::strtolower($rfo->getResult()) == 'pen') {
                $this->savePaymentInfo($id_cart, $rfo);

                if ($this->context->cart->OrderExists() == true) {
                    $orderId = Order::getOrderByCartId($this->context->cart->id);
                    $order = new Order($orderId);

                    Logger::log('order current state -> ' . $order->getCurrentState(), 1);

                    if (\Tools::strtolower($rfo->getResult()) == 'ok' && $order->getCurrentState() !== (int) Configuration::get('PS_OS_PAYMENT')) {
                        $order->setCurrentState((int) Configuration::get('PS_OS_PAYMENT'));

                        Logger::log('order state changed -> ' . $order->getCurrentState(), 1);
                    }
                } else {
                    $currency = new Currency($cart->id_currency);

                    $total = CurrencyHelper::fromMinUnitToAmountXPay(
                        $rfo->getAmount(),
                        CurrencyHelper::getCurrencyISOCode($currency->id)
                    );

                    $status = (int) Configuration::get('PS_OS_PAYMENT');

                    if (\Tools::strtolower($rfo->getResult()) == 'pen') {
                        $status = $this->module->getXpayPendingPaymentStatus();
                    }

                    $this->module->validateOrder(
                        $cart->id,
                        $status,
                        $total,
                        $this->module->displayName,
                        null,
                        ['transaction_id' => $rfo->getCodTrans()],
                        (int) $currency->id,
                        false,
                        $customer->secure_key
                    );
                }
            } else {
                // if order exists change status to payment error
                if ($this->context->cart->OrderExists() == true) {
                    $orderId = Order::getOrderByCartId($this->context->cart->id);
                    $order = new Order($orderId);

                    $order->setCurrentState((int) Configuration::get('PS_OS_ERROR'));
                } else {
                    Logger::log('Not valid transaction: ' . $rfo->getMessage(), 2);
                }
            }
        } else {
            Logger::log('Wrong mac code', 4);
            header('500 Internal Server Error', true, 500);
        }
        exit;
    }

    private function savePaymentInfo($id_cart, $rfo)
    {
        $oPI = new PaymentInfo();
        $oPI->codTrans = $rfo->getCodTrans();
        $oPI->idCart = $id_cart;
        $oPI->amount = CurrencyHelper::fromMinUnitToAmountXPay($rfo->getAmount(), $rfo->getCurrency());
        $oPI->currency = $rfo->getCurrency();
        $oPI->brand = $rfo->getBrand();
        $oPI->result = $rfo->getResult();
        $date = DateTime::createFromFormat('YmdHis', $rfo->getDate() . $rfo->getTime());
        if ($date) {
            $oPI->date = $date->format('Y-m-d H:i:s');
        }
        $oPI->autCode = $rfo->getCodAut();
        $oPI->pan = $rfo->getPan();
        $oPI->exp = $rfo->getExp();
        $oPI->nationality = $rfo->getNationality();
        $oPI->firstName = $rfo->getFirstName();
        $oPI->lastName = $rfo->getLastName();
        $oPI->mail = $rfo->getMail();
        $oPI->message = $rfo->getMessage();
        $oPI->contractNumber = $rfo->getContractNumber();
        $oPI->save();
    }
}
