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
 * @version     7.1.0
 */

namespace Nexi\NPG\Build;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\NPG\Redirect\NPG;
use Nexi\Redirect\Settings;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;

class NPGBuild
{
    /**
     * @var \NexiXPay
     */
    private $module;

    public function __construct(\NexiXPay $module)
    {
        $this->module = $module;
    }

    /**
     * return payment methods to be displayed for the payment gateway
     *
     * @return array
     */
    public function getAPM($context)
    {
        $npg = new NPG($this->module);

        $npg->syncPaymentMethods();

        $apmOptions = [];

        if ($npg->isCurrencyValidForApm(CurrencyHelper::getCurrencyISOCode($context->cart->id_currency), 'CARDS')) {
            $paymentLink = $this->module->createModuleLink($this->module->name, 'npg-pay', ['selected_card' => 'CARDS'], true);

            $apmDati = [
                'paymentLink' => $paymentLink,
                'this_path' => $this->module->getPathUri(),
                'description' => $this->module->l('Pay securely by credit, debit and prepaid card. Powered by Nexi.', 'npg'),
                'imageList' => $npg->getSortedImageLinks(),
            ];

            $templatePath = Helper::get_front_template_path('npg_emb.tpl');

            $apmOptions[] = $this->module->getNewPaymentOption(
                $this->module->l('Payments cards', 'npg'),
                $paymentLink,
                null,
                'npgbuild',
                $this->module->fetchTemplate($templatePath, $apmDati),
                true
            );
        }

        return array_merge($apmOptions, $npg->getAlternativeMethods($context));
    }

    /**
     * from cart id creates an orderId
     *
     * @param int $cartId
     *
     * @return string
     */
    public static function calculateOrderId($cartId)
    {
        list($reuse, $orderId) = (new \OrderInfo())->canReuseOrderId($cartId);

        if ($reuse && $orderId !== null) {
            return $orderId;
        }

        return Helper::generate_random_id(18, $cartId);
    }

    /**
     * returns the payload for the payment initialization request
     *
     * @return array
     */
    public function getPayload($context)
    {
        $cart = $context->cart;

        $orderId = self::calculateOrderId($cart->id);

        $currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        $amount = CurrencyHelper::calculateAmountToMinUnitNPG(Helper::getTotalFromCart($cart), $currency);

        $config = Settings::getConfiguration();

        $payload = [
            'merchantUrl' => \Context::getContext()->shop->getBaseURL(true),
            'order' => [
                'orderId' => (string) $orderId,
                'amount' => (string) $amount,
                'currency' => $currency,
                'description' => 'PS Order: ' . $cart->id,
                'customField' => 'Prestashop ' . \Tools::substr(_PS_VERSION_, 0, 3) . '.x - ' . $this->module->name . ' ' . $this->module->version,
                'customerId' => $cart->id_customer,
            ],
            'paymentSession' => [
                'actionType' => 'PAY',
                'amount' => (string) $amount,
                'recurrence' => [
                    'action' => NO_RECURRING,
                ],
                'exemptions' => 'NO_PREFERENCE',
                'language' => Settings::getPaymentGatewayLanguage($context),
                'resultUrl' => $this->module->createModuleLink($this->module->name, 'npg-return', ['orderId' => $orderId]),
                'cancelUrl' => $this->module->createModuleLink($this->module->name, 'npg-cancel'),
                'notificationUrl' => $this->module->createModuleLink($this->module->name, 'npg-callback'),
                'paymentService' => 'CARDS',
            ],
        ];

        if ($config['3ds']) {
            $npg = new NPG($this->module);

            $payload = $npg->get3dsParams($payload, $cart);
        }

        return $payload;
    }

    public function getFinalizePayload($orderId)
    {
        $cartId = NPG::getCartId($orderId);

        $orderInfo = new \OrderInfo();

        $sessionId = $orderInfo->getSessionId($cartId, $orderId);

        if ($sessionId == null) {
            throw new \Exception('Session ID is not found for orderId: ' . $orderId);
        }

        return ['sessionId' => $sessionId];
    }
}
