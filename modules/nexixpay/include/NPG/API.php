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

namespace Nexi\NPG\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\NPG\APIKey;
use Nexi\Redirect\Error\NPG\CustomerNotFound;
use Nexi\Redirect\Error\NPG\FinalizeInitialization;
use Nexi\Redirect\Error\NPG\OrderNotFound;
use Nexi\Redirect\Error\NPG\PaymentInitialization;
use Nexi\Redirect\Settings;
use Nexi\Utility\CurlCall;
use Nexi\Utility\Logger;

class API
{
    private $baseUrl;
    private $apiKey;

    /**
     * @param \Shop|null $shop
     */
    public function __construct($shop = null)
    {
        if (\Configuration::get('NEXIXPAY_TEST')) {
            $this->baseUrl = 'https://stg-ta.nexigroup.com/api/phoenix-0.0/psp/api/v1/';
        } else {
            $this->baseUrl = 'https://xpay.nexigroup.com/api/phoenix-0.0/psp/api/v1/';
        }

        $config = Settings::getConfiguration($shop);

        $this->apiKey = $config['api_key'];
    }

    private function getRequsetUrl($url)
    {
        return $this->baseUrl . $url;
    }

    private function GET($url, $payload = [], $extraHeaders = [])
    {
        return CurlCall::exec_REST_CURL('GET', $url, $payload, $this->apiKey, $extraHeaders);
    }

    private function POST($url, $payload, $extraHeaders = [])
    {
        return CurlCall::exec_REST_CURL('POST', $url, $payload, $this->apiKey, $extraHeaders);
    }

    /**
     * checks npg api key and if valid returna avaiable payment methods
     *
     * @return array
     */
    public function getPaymentMethods()
    {
        $url = $this->getRequsetUrl('payment_methods');

        try {
            $response = $this->GET($url);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionWarning(new \Exception('response - ' . json_encode($response)));

            throw new APIKey();
        }

        return $response['response']['paymentMethods'];
    }

    /**
     * creates order on npg gateway and returns the link to which the user must be redirected to for the payment
     *
     * @param array $payload
     *
     * @return string
     */
    public function getPaymentLink($payload)
    {
        $url = $this->getRequsetUrl('orders/hpp');

        try {
            $response = $this->POST($url, $payload);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionError(new PaymentInitialization('Unablee to initialize payment - ' . json_encode($response)));

            throw new PaymentInitialization();
        }

        try {
            $oI = new \OrderInfo();

            // if it is build variant and there are already saved info for this cartId and orderId (from a build payment not completed), overwrite them
            if (\NexiXPay::isXPayBuild() && $oI->cartIdAndOrderIdExists(NPG::getCartId($payload['order']['orderId']), $payload['order']['orderId'])) {
                $oI->updateExistingPaymentInfo(
                    NPG::getCartId($payload['order']['orderId']),
                    $payload['order']['orderId'],
                    $response['response']['securityToken'],
                    $payload['paymentSession']['recurrence']['action'] == CONTRACT_CREATION ? $payload['paymentSession']['recurrence']['contractId'] : null
                );
            } else {
                $oI->saveInfo(
                    NPG::getCartId($payload['order']['orderId']),
                    $payload['order']['orderId'],
                    $response['response']['securityToken'],
                    $payload['paymentSession']['recurrence']['action'] == CONTRACT_CREATION ? $payload['paymentSession']['recurrence']['contractId'] : null
                );
            }
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc);

            throw new \Exception($exc->getMessage());
        }

        return $response['response']['hostedPage'];
    }

    /**
     * @param string $orderId
     *
     * @return array
     */
    public function getOrder($orderId)
    {
        $url = $this->getRequsetUrl('orders/' . $orderId);

        try {
            $response = $this->GET($url);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] === 404) {
            throw new OrderNotFound();
        }

        if ($response['status_code'] !== 200) {
            throw new \Exception('Unable to get order related info');
        }

        return $response['response'];
    }

    /**
     * @param string $customerId
     *
     * @return array
     */
    public function getCustomerContract($customerId)
    {
        $url = $this->getRequsetUrl('contracts/customers/' . $customerId);

        try {
            $response = $this->GET($url);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] === 404) {
            throw new CustomerNotFound();
        }

        if ($response['status_code'] !== 200) {
            throw new \Exception('Unable to get customer related info');
        }

        return $response['response'];
    }

    /**
     * @param string $operationId
     * @param array $payload
     *
     * @return array
     */
    public function refund($operationId, $payload)
    {
        $url = $this->getRequsetUrl('operations/' . $operationId . '/refunds');

        try {
            $extraHeaders = [
                'Idempotency-Key: ' . CurlCall::generateUuid(),
            ];

            $response = $this->POST($url, $payload, $extraHeaders);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionError(new \Exception('Unablee to performe refund - ' . json_encode(['payload' => $payload, 'response' => $response])));

            throw new \Exception('Error while proccessing refund request.');
        }

        return $response['response'];
    }

    /**
     * @param string $operationId
     * @param array $payload
     *
     * @return array
     */
    public function account($operationId, $payload)
    {
        $url = $this->getRequsetUrl('operations/' . $operationId . '/captures');

        try {
            $extraHeaders = [
                'Idempotency-Key: ' . CurlCall::generateUuid(),
            ];

            $response = $this->POST($url, $payload, $extraHeaders);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionError(new \Exception('Unablee to performe account - ' . json_encode(['payload' => $payload, 'response' => $response])));

            throw new \Exception('Error while proccessing account request.');
        }

        return $response['response'];
    }

    public function deactivateContract($contractId)
    {
        try {
            $url = $this->getRequsetUrl('contracts/' . $contractId . '/deactivation');

            $response = $this->POST($url, []);
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc);
        }

        if ($response['status_code'] !== 200) {
            throw new \Exception('Error deactivation contract ' . $contractId . ' - response: ' . json_encode($response));
        }

        return false;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function buildPayment($payload)
    {
        $url = $this->getRequsetUrl('orders/build');

        try {
            $response = $this->POST($url, $payload);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionError(new PaymentInitialization('Unablee to initialize payment - ' . json_encode($response)));

            throw new PaymentInitialization();
        }

        try {
            $oI = new \OrderInfo();

            // there are already saved info for this cartId and orderId, from a previous not completed build payment, overwrite them
            if ($oI->cartIdAndOrderIdExists(NPG::getCartId($payload['order']['orderId']), $payload['order']['orderId'])) {
                $oI->updateExistingPaymentInfo(
                    NPG::getCartId($payload['order']['orderId']),
                    $payload['order']['orderId'],
                    $response['response']['securityToken'],
                    null,
                    $response['response']['sessionId']
                );
            } else {
                $oI->saveInfo(
                    NPG::getCartId($payload['order']['orderId']),
                    $payload['order']['orderId'],
                    $response['response']['securityToken'],
                    null,
                    $response['response']['sessionId']
                );
            }
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc);

            throw new \Exception($exc->getMessage());
        }

        unset($response['response']['securityToken']);
        unset($response['response']['sessionId']);

        return array_merge(['orderId' => $payload['order']['orderId']], $response['response']);
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function buildPaymentFinalize($payload)
    {
        $url = $this->getRequsetUrl('build/finalize_payment');

        try {
            $response = $this->POST($url, $payload);
        } catch (\Exception $exc) {
            throw new \Exception($exc->getMessage());
        }

        if ($response['status_code'] !== 200) {
            Logger::logExceptionError(new FinalizeInitialization('Unablee to finalize payment - ' . json_encode($response)));

            throw new FinalizeInitialization();
        }

        return $response['response'];
    }
}
