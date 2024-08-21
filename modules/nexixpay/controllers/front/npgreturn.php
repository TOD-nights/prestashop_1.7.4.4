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
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\NPG\Redirect\NPG;
use Nexi\Utility\Helper;
use Nexi\Utility\Logger;

class NexiXPayNPGReturnModuleFrontController extends \NexiXPayBaseModuleFrontController
{
    public function postProcess()
    {
        Logger::log("redirect - " . date('d-m-Y H:i:s'), 1);

        $orderId = Tools::getValue('orderId');

        $orderInfo = new OrderInfo();

        if ($orderInfo->chekAndTakeLock($orderId) === false) {
            Logger::logExceptionError(new \Exception('Couldn\'t get execution lock'));

            $this->redirectToErrorPage($this->module->l('An error occured during payment', 'npgreturn'));

            return;
        }

        Logger::log("redirect got lock - " . date('d-m-Y H:i:s'), 1);

        $cartId = NPG::getCartId($orderId);

        $cart = new Cart($cartId);

        if (
            $cart->id_customer == 0 || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0 || !$this->module->active
        ) {
            $orderInfo->releaseLock($orderId);

            Tools::redirect('index.php?controller=order&step=1');
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            $orderInfo->releaseLock($orderId);

            Tools::redirect('index.php?controller=order&step=1');
        }

        $npg = new NPG($this->module);

        $c = 0;

        $authorizationOperation = null;

        do {
            sleep(1);

            ++$c;

            $authorizationOperation = $npg->getAuthorizationOperation($orderId, NexiXPay::getShopFromCart($cart));

            if ($c == 10) {
                Logger::log('Reached max number of GET requests for order: ' . $orderId . ' - cart: ' . $cartId, 1);
                break;
            }

            if ($authorizationOperation == null) {
                Logger::logExceptionError(new Exception('Authorization operation not found for order: ' . $orderId . ' - cart: ' . $cartId));
            }
        } while ($authorizationOperation == null || $authorizationOperation['operationResult'] == PAYMENT_S_PENDING);

        if ($authorizationOperation == null || in_array($authorizationOperation['operationResult'], PAYMENT_FAILURE)) {
            $orderInfo->releaseLock($orderId);

            $this->redirectToErrorPage($this->module->l('An error occured during payment', 'npgreturn'));

            return;
        }

        if (in_array($authorizationOperation['operationResult'], PAYMENT_S_CANCELLED)) {
            $orderInfo->releaseLock($orderId);

            $this->redirectToCancelPage();

            return;
        }

        $status = $npg->getStatusFromAuthorizationOperationResult($authorizationOperation['operationResult']);

        if ($status === null) {
            Logger::logExceptionCritical(new Exception('Not managed status for order - ' . $orderId . ' - cart - ' . $cartId . ' - ' . json_encode($authorizationOperation)));

            $orderInfo->releaseLock($orderId);

            $this->redirectToErrorPage($this->module->l('An error occured during payment', 'npgreturn'));

            return;
        }

        // if order does not exist, create it and then redirect to thank-you page, otherwise check if the status is correct and change it
        if ($cart->OrderExists()) {
            $order = new Order(Order::getOrderByCartId($cart->id));

            if ($order->getCurrentState() != (int) Configuration::get('PS_OS_PAYMENT') && $order->getCurrentState() != $status) {
                $order->setCurrentState($status);
            }
        } else {
            $total = Helper::getTotalFromCart($cart);

            $currency = new Currency($cart->id_currency);

            $this->module->validateOrder(
                $cart->id,
                $status,
                $total,
                $this->module->displayName,
                null,
                ['transaction_id' => $orderId],
                (int) $currency->id,
                false,
                $customer->secure_key
            );

            $orderInfo->setOrderCreated($orderId);
        }

        $order = new Order(Order::getOrderByCartId($cart->id));

        // if status is in PENDING show the error page because the final status isn't sure
        if ($order->getCurrentState() == $this->module->getXpayPendingPaymentStatus()) {
            Logger::logExceptionCritical(new Exception('Order in pending, don\'t have a final status so returning to error page - ' . $orderId . ' - cart - ' . $cartId . ' - ' . json_encode($authorizationOperation)));

            $orderInfo->releaseLock($orderId);

            $this->redirectToErrorPage($this->module->l('An error occured during payment', 'npgreturn'));

            return;
        }

        $npg->saveOneClickToken($orderId, $customer->id, $authorizationOperation);

        $orderInfo->releaseLock($orderId);

        Tools::redirect('index.php?controller=order-confirmation&id_cart=' . $cart->id . '&id_module=' . $this->module->id . '&id_order=' . $order->id . '&key=' . $customer->secure_key);
    }
}
