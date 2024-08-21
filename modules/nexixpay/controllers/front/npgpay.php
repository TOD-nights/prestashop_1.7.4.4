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

use Nexi\NPG\Build\NPGBuild;
use Nexi\NPG\Redirect\API;
use Nexi\NPG\Redirect\NPG;
use Nexi\Redirect\Error\NPG\FinalizeInitialization;
use Nexi\Redirect\Error\NPG\PaymentInitialization;
use Nexi\Utility\Helper;
use Nexi\Utility\Logger;

class NexiXPayNPGPayModuleFrontController extends \NexiXPayBaseModuleFrontController
{
    public function postProcess()
    {
        $cart = $this->context->cart;

        if (
            $cart->id_customer == 0 || $cart->id_address_delivery == 0
            || $cart->id_address_invoice == 0 || !$this->module->active
        ) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $authorized = false;

        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == $this->module->name) {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            $this->redirectToErrorPage($this->module->l('This payment method is not available.', 'npgpay'));

            return;
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $selectedCard = \Tools::getValue('selected_card');

        if (NexiXPay::isXPayBuild() && $selectedCard === 'CARDS') {
            $this->manageBuildPayment($cart, $customer);
        } else {
            $this->manageRedirectPayment();
        }
    }

    private function manageRedirectPayment()
    {
        try {
            $selectedCard = \Tools::getValue('selected_card');
            $saveToken = \Tools::getValue('save_token');
            $selectedToken = \Tools::getValue('selected_token');

            $api = new API();

            $npg = new NPG($this->module);

            $npgPayload = $npg->getPayload($this->context, $selectedToken, $saveToken == '1', $selectedCard);

            (new OrderInfo())->setPaymentStarted($npgPayload['order']['orderId']);

            $redirectLink = $api->getPaymentLink($npgPayload);
            Tools::redirectLink($redirectLink);
        } catch (PaymentInitialization $exc) {
            $this->redirectToErrorPage($this->module->l('Error while initializing the payment.', 'npgpay'));
        } catch (Exception $exc) {
            Logger::logExceptionError($exc);

            $this->redirectToErrorPage($this->module->l('Unable to initialize the payment.', 'npgpay'));
        }
    }

    private function manageBuildPayment($cart, $customer)
    {
        try {
            $orderId = \Tools::getValue('order_id');

            $api = new API();

            $npgBuild = new NPGBuild($this->module);

            $orderInfo = new OrderInfo();

            $orderInfo->setPaymentStarted($orderId);

            $res = $api->buildPaymentFinalize($npgBuild->getFinalizePayload($orderId));

            if (!in_array($res['state'], ['REDIRECTED_TO_EXTERNAL_DOMAIN', 'PAYMENT_COMPLETE'])) {
                throw new \Exception('Invalid state returned from payment finalize: ' . json_encode($res));
            }

            if ($res['state'] === 'REDIRECTED_TO_EXTERNAL_DOMAIN') {
                Tools::redirectLink($res['url']);
            } else {
                if (!isset($res['operation']) || empty($res['operation'])) {
                    throw new \Exception('Operation not set on finalize response: ' . json_encode($res));
                }

                $authorizationOperation = $res['operation'];

                if (in_array($authorizationOperation['operationResult'], PAYMENT_FAILURE)) {
                    throw new \Exception('Payment faild, orderId: ' . $orderId . ' - cart - ' . $cart->id . ' - ' . json_encode($authorizationOperation));
                }

                $npg = new NPG($this->module);

                $status = $npg->getStatusFromAuthorizationOperationResult($authorizationOperation['operationResult']);

                if ($status === null) {
                    throw new \Exception('Not managed status for order - ' . $orderId . ' - cart - ' . $cart->id . ' - ' . json_encode($authorizationOperation));
                }

                if ($orderInfo->chekAndTakeLock($orderId) === false) {
                    throw new \Exception('Couldn\'t get execution lock');
                }

                Logger::log("npgpay got lock - " . date('d-m-Y H:i:s'), 1);

                $total = Helper::getTotalFromCart($cart);

                $currency = new \Currency($cart->id_currency);

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

                $orderInfo->releaseLock($orderId);

                $order = new \Order(Order::getOrderByCartId($cart->id));

                // if status is in PENDING show the error page because the final status isn't sure
                if ($order->getCurrentState() == $this->module->getXpayPendingPaymentStatus()) {
                    throw new \Exception('Order in pending, don\'t have a final status so returning to error page - ' . $orderId . ' - cart - ' . $cart->id . ' - ' . json_encode($authorizationOperation));
                }

                \Tools::redirect('index.php?controller=order-confirmation&id_cart=' . $cart->id . '&id_module=' . $this->module->id . '&id_order=' . $order->id . '&key=' . $customer->secure_key);
            }
        } catch (FinalizeInitialization $exc) {
            $this->redirectToErrorPage($this->module->l('Error while finalizing the payment.', 'npgpay'));
        } catch (Exception $exc) {
            Logger::logExceptionError($exc);

            $this->redirectToErrorPage($this->module->l('Unable to finalize the payment.', 'npgpay'));
        }
    }
}
