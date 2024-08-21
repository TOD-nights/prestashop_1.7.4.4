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
use Nexi\Redirect\Settings;
use Nexi\Utility\Helper;
use Nexi\Utility\Logger;

class NexiXPayNPGCallbackModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    public function postProcess()
    {
        Logger::log("notification - " . date('d-m-Y H:i:s'), 1);

        $request = json_decode(Tools::file_get_contents('php://input'), true);

        if (!isset($request['securityToken']) || !array_key_exists('operation', $request) || !isset($request['operation']['orderId'])) {
            Logger::logExceptionCritical(new Exception('Required info not set in request: ' . json_encode($request)));

            header('500 Internal Server Error', true, 500);
            exit;
        }

        $npgOrderId = $request['operation']['orderId'];

        $orderInfo = new OrderInfo();

        if ($orderInfo->chekAndTakeLock($npgOrderId) === false) {
            Logger::logExceptionError(new \Exception('Couldn\'t get execution lock'));

            header('500 Internal Server Error', true, 500);
            exit;
        }

        Logger::log("notification got lock - " . date('d-m-Y H:i:s'), 1);

        $cartId = NPG::getCartId($npgOrderId);

        $securityToken = $orderInfo->getSecurityToken($cartId);

        if ($request['securityToken'] != $securityToken) {
            Logger::logExceptionCritical(new Exception('Invalid securityToken for cart: ' . $cartId));

            $orderInfo->releaseLock($npgOrderId);

            header('500 Internal Server Error', true, 500);
            $this->checkPendingOrders();
            exit;
        }

        $cart = new Cart($cartId);

        if (
            $cart->id_customer == 0 || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0 || !$this->module->active
        ) {
            Logger::logExceptionCritical(new Exception('Missing customer data for cart: ' . $cartId));

            $orderInfo->releaseLock($npgOrderId);

            header('500 Internal Server Error', true, 500);
            $this->checkPendingOrders();
            exit;
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Logger::logExceptionCritical(new Exception('Non-existent customer for cart: ' . $cartId . ' - customer: ' . $cart->id_customer));

            $orderInfo->releaseLock($npgOrderId);

            header('500 Internal Server Error', true, 500);
            $this->checkPendingOrders();
            exit;
        }

        if (in_array($request['operation']['operationResult'], PAYMENT_S_CANCELLED)) {
            Logger::log('Payment canceled', 1);

            $orderInfo->releaseLock($npgOrderId);

            header('OK', true, 200);
            $this->checkPendingOrders();
            exit;
        }

        $status = (new NPG($this->module))->getStatusFromAuthorizationOperationResult($request['operation']['operationResult']);

        if ($status === null) {
            Logger::logExceptionCritical(new Exception('Not managed status for order - ' . json_encode($request)));

            $orderInfo->releaseLock($npgOrderId);

            header('500 Internal Server Error', true, 500);
            $this->checkPendingOrders();
            exit;
        }

        if ($cart->OrderExists()) {
            $orderId = Order::getOrderByCartId($cart->id);
            $order = new Order($orderId);

            if ($order->getCurrentState() == $status) {
                Logger::log('Order already in status: ' . $status . ' - current status: ' . $order->getCurrentState(), 1);

                $orderInfo->releaseLock($npgOrderId);

                header('OK', true, 200);
                $this->checkPendingOrders();
                exit;
            }

            if ($order->getCurrentState() == $this->module->getXpayPendingPaymentStatus()) {
                $order->setCurrentState($status);
            }
        } elseif ($status != (int) Configuration::get('PS_OS_ERROR')) {    // if order has to be created it can't have the ERROR status
            $total = Helper::getTotalFromCart($cart);

            $currency = new Currency($cart->id_currency);

            $this->module->validateOrder(
                $cart->id,
                $status,
                $total,
                $this->module->displayName,
                null,
                ['transaction_id' => $npgOrderId],
                (int) $currency->id,
                false,
                $customer->secure_key
            );

            $orderInfo->setOrderCreated($npgOrderId);
        }

        if ($status == (int) Configuration::get('PS_OS_PAYMENT')) {
            $npg = new NPG($this->module);

            $npg->saveOneClickToken($npgOrderId, $customer->id, $request['operation']);
        }

        $orderInfo->releaseLock($npgOrderId);

        header('OK', true, 200);

        $this->checkPendingOrders();
        exit;
    }

    /**
     * checks if there are any pending orders and try to update status from GET request information
     * the minimum time between one check and the next is 5 min (300s)
     *
     * @return void
     */
    private function checkPendingOrders()
    {
        if (!Settings::isGatewayNPG()) {
            return;
        }

        if (!Configuration::get('NEXIXPAY_LAST_PENDING_ORDERS_CHECK') || Configuration::get('NEXIXPAY_LAST_PENDING_ORDERS_CHECK') == '') {
            Configuration::updateValue('NEXIXPAY_LAST_PENDING_ORDERS_CHECK', time());
        }

        $lastCheck = (int) Configuration::get('NEXIXPAY_LAST_PENDING_ORDERS_CHECK');

        if (time() - $lastCheck < 300) {
            return;
        }

        Configuration::updateValue('NEXIXPAY_LAST_PENDING_ORDERS_CHECK', time());

        $minDate = (new DateTime())->modify('-30 days')->format('Y-m-d');

        $query = '  SELECT *
                    FROM ' . _DB_PREFIX_ . "orders
                    WHERE current_state = '" . pSQL($this->module->getXpayPendingPaymentStatus()) . "'
                    AND module = '" . pSQL($this->module->name) . "'
                    AND DATE(date_add) >= '" . pSQL($minDate) . "'
                    ORDER BY date_add DESC";

        $orders = Db::getInstance()->executeS($query);

        $npg = new NPG($this->module);

        foreach ($orders as $order) {
            $cartId = $order['id_cart'];

            if (!NPG::isOrder($cartId)) {
                continue;
            }

            $orderInfo = (new OrderInfo())->getOrderByCartId($cartId);

            if ($orderInfo == null) {
                Logger::logExceptionWarning(new Exception('Order info not found, cart: ' . $cartId));
                continue;
            }

            $authorizationOperation = $npg->getAuthorizationOperation($orderInfo['order_id'], NexiXPay::getShopFromCartId($cartId));

            if ($authorizationOperation === null) {
                Logger::logExceptionWarning(new Exception('Authorization operation not found for order: ' . $orderInfo['order_id'] . ' - cart: ' . $cartId));
                continue;
            }

            $status = $npg->getStatusFromAuthorizationOperationResult($authorizationOperation['operationResult']);

            if ($status === null) {
                Logger::logExceptionCritical(new Exception('Not managed status for order - ' . json_encode($authorizationOperation)));

                continue;
            }

            $orderObj = new \Order($order['id']);

            if ($orderObj->getCurrentState() == $status) {
                Logger::log('Order already in status: ' . $status . ' - current status: ' . $orderObj->getCurrentState(), 1);

                continue;
            }

            Logger::log(__FUNCTION__ . ':: cart: ' . $cartId . ' - changing status to: ' . $status, 1);
            $orderObj->setCurrentState($status);
        }
    }
}
