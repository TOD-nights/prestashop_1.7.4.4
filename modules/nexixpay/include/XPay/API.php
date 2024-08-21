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

namespace Nexi\XPay\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\APIAccount;
use Nexi\Redirect\Error\APIAvailableMethods;
use Nexi\Redirect\Error\APIOrderDetail;
use Nexi\Redirect\Error\APIRefund;
use Nexi\Redirect\Error\CurlCall as ErrorCurlCall;
use Nexi\Redirect\Error\NexiError;
use Nexi\Redirect\Error\Request;
use Nexi\Redirect\Error\Response;
use Nexi\Utility\CurlCall;
use Nexi\Utility\Logger;
use Nexi\XPay\Build\Payload\Request\RequestNonce;
use Nexi\XPay\Build\Payload\Request\RequestNonceCreazioneContratto;
use Nexi\XPay\Build\Payload\Response\ResponseNonce;
use Nexi\XPay\Redirect\Payload\Request\RequestAccount;
use Nexi\XPay\Redirect\Payload\Request\RequestAvailableMethods;
use Nexi\XPay\Redirect\Payload\Request\RequestOrderDetail;
use Nexi\XPay\Redirect\Payload\Request\RequestRefund;
use Nexi\XPay\Redirect\Payload\Response\ResponseAccount;
use Nexi\XPay\Redirect\Payload\Response\ResponseAvailableMethods;
use Nexi\XPay\Redirect\Payload\Response\ResponseOrderDetail;
use Nexi\XPay\Redirect\Payload\Response\ResponseRefund;

class API
{
    const XPAY_URI_REFUND = 'ecomm/api/bo/storna';
    const XPAY_URI_RECURRING = 'ecomm/api/recurring/pagamentoRicorrente';
    const XPAY_URI_ORDERDETAIL = 'ecomm/api/bo/situazioneOrdine';
    const XPAY_URI_ACCOUNT = 'ecomm/api/bo/contabilizza';
    const XPAY_URI_ACCOUNT_INFO = 'ecomm/api/profileInfo';
    const XPAY_URI_PAGA_NONCE = 'ecomm/api/hostedPayments/pagaNonce';
    const XPAY_URI_PAGA_NONCE_CREAZIONE_CONTRATTO = 'ecomm/api/hostedPayments/pagaNonceCreazioneContratto';
    const XPAY_URI_RECURRING_3DS = 'ecomm/api/recurring/pagamentoRicorrente3DS';
    const XPAY_ENV_PRODUCTION = 'https://ecommerce.nexi.it/';
    const XPAY_ENV_INTEGRATION = 'https://int-ecommerce.nexi.it/';

    private $apiKey;
    private $privateKey;
    private $requestUrl;

    public function __construct($env, $apiKey, $privateKey)
    {
        $this->apiKey = trim($apiKey);
        $this->privateKey = trim($privateKey);

        switch ($env) {
            case static::XPAY_ENV_PRODUCTION:
                $this->requestUrl = static::XPAY_ENV_PRODUCTION;
                break;
            case static::XPAY_ENV_INTEGRATION:
                $this->requestUrl = static::XPAY_ENV_INTEGRATION;
                break;
            default:
                throw new NexiError('invalid environment');
        }
    }

    public function refund($transactionCode, $amount, $currency)
    {
        try {
            $request = new RequestRefund(
                $this->apiKey,
                $this->privateKey,
                $amount,
                $currency,
                $transactionCode
            );

            $payLoad = $request->getPayload();
            $url = $this->requestUrl . $this::XPAY_URI_REFUND;

            $curl = new CurlCall($url, $payLoad);
            $responseRaw = $curl->execCurl();

            $response = new ResponseRefund($responseRaw, $this->privateKey);

            if (!$response->isSuccess()) {
                Logger::log($response->getResponse()['errore']['messaggio'] . ' - idOperazione: ' . $response->getResponse()['idOperazione'], 1);
                throw new APIRefund($response->getResponse()['errore']['messaggio']);
            }
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
            throw new APIRefund('Refund Error', 0, $exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIRefund('Refund Error', 0, $exc);
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIRefund('Refund Error', 0, $exc);
        }
    }

    public function account($transactionCode, $amount, $currency)
    {
        try {
            $request = new RequestAccount(
                $this->apiKey,
                $this->privateKey,
                $amount,
                $currency,
                $transactionCode
            );

            $payLoad = $request->getPayload();
            $url = $this->requestUrl . $this::XPAY_URI_ACCOUNT;

            $curl = new CurlCall($url, $payLoad);
            $responseRaw = $curl->execCurl();

            $response = new ResponseAccount($responseRaw, $this->privateKey);

            if (!$response->isSuccess()) {
                throw new APIAccount('Accounting Error - ' . $response->getResponse()['errore']['messaggio']);
            }

            return json_encode($response->getResponse());
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
            throw new APIAccount('Accounting Error', 0, $exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIAccount('Accounting Error', 0, $exc);
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIAccount('Accounting Error', 0, $exc);
        }
    }

    public function orderDetail($transactionCode)
    {
        try {
            $request = new RequestOrderDetail(
                $this->apiKey,
                $this->privateKey,
                $transactionCode
            );

            $payLoad = $request->getPayload();
            $url = $this->requestUrl . $this::XPAY_URI_ORDERDETAIL;

            $curl = new CurlCall($url, $payLoad);
            $responseRaw = $curl->execCurl();

            $response = new ResponseOrderDetail($responseRaw, $this->privateKey);

            if (!$response->isSuccess()) {
                throw new APIOrderDetail('Order Detail Error');
            }

            return $response->getResponse();
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
            throw new APIOrderDetail('Order Detail Error', 0, $exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIOrderDetail('Order Detail Error', 0, $exc);
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            throw new APIOrderDetail('Order Detail Error', 0, $exc);
        }
    }

    public function availableMethods($platform, $platformVers, $pluginVers)
    {
        try {
            $request = new RequestAvailableMethods(
                $this->apiKey,
                $this->privateKey,
                $platform,
                $platformVers,
                $pluginVers
            );

            $payLoad = $request->getPayload();
            $url = $this->requestUrl . $this::XPAY_URI_ACCOUNT_INFO;
            $curl = new CurlCall($url, $payLoad);

            $responseRaw = $curl->execCurl();

            $response = new ResponseAvailableMethods($responseRaw, $this->privateKey);

            if (!$response->isSuccess()) {
                throw new APIAvailableMethods('Get Available Methods Error');
            }

            return $response->getResponse();
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
            throw new APIAvailableMethods('Get Available Methods Error', 0, $exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception(json_encode(['response' => $responseRaw])));
            throw new APIAvailableMethods('Get Available Methods Error', 0, $exc);
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception(json_encode(['response' => $responseRaw])));
            throw new APIAvailableMethods('Get Available Methods Error', 0, $exc);
        }
    }

    // XPAY BUILD

    /**
     * payment with the card to be saved
     *
     * @param string $codiceTransazione
     * @param int $importo
     * @param int $divisa
     * @param string $nonce
     * @param string $numeroContratto
     * @param string $TCONTAB 'D' | 'C'
     * @param string|null $nome
     * @param string|null $cognome
     * @param string|null $mail
     *
     * @return array [booelan, array|null]
     */
    public function pagaNonceCreazioneContratto($codiceTransazione, $importo, $divisa, $nonce, $numeroContratto, $TCONTAB = 'D', $nome = null, $cognome = null, $mail = null)
    {
        $res = false;

        try {
            $request = new RequestNonceCreazioneContratto(
                $this->apiKey,
                $this->privateKey,
                $codiceTransazione,
                $importo,
                $divisa,
                $nonce,
                $numeroContratto,
                $TCONTAB,
                $nome,
                $cognome,
                $mail
            );

            $payLoad = $request->getPayload();
            $url = $this->requestUrl . $this::XPAY_URI_PAGA_NONCE_CREAZIONE_CONTRATTO;
            $curl = new CurlCall($url, $payLoad);

            $responseRaw = $curl->execCurl();

            $response = new ResponseNonce($responseRaw, $this->privateKey);

            $retResponse = $response->getResponse();

            if (!$response->isSuccess()) {
                Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));

                return [$res, $retResponse];
            }

            $res = true;
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));
        }

        return [$res, $retResponse ?? null];
    }

    /**
     * Base payment or OneClick subsequent payment
     *
     * @param string $codiceTransazione
     * @param int $importo
     * @param int $divisa
     * @param string $nonce
     * @param string $TCONTAB 'D' | 'C'
     * @param bool $oneClickSubsequent true if it is a oneclick subsequent payment (payment with saved card)
     * @param string|null $nome
     * @param string|null $cognome
     * @param string|null $mail
     *
     * @return array [booelan, array|null]
     */
    public function pagaNonceOneClickSubsequent($codiceTransazione, $importo, $divisa, $nonce, $TCONTAB = 'D', $oneClickSubsequent = false, $nome = null, $cognome = null, $mail = null)
    {
        $res = false;

        try {
            $request = new RequestNonce(
                $this->apiKey,
                $this->privateKey,
                $codiceTransazione,
                $importo,
                $divisa,
                $nonce,
                $TCONTAB,
                $nome,
                $cognome,
                $mail
            );

            $payLoad = $request->getPayload();

            $url = $this->requestUrl . $this::XPAY_URI_PAGA_NONCE;

            if ($oneClickSubsequent) {
                $url = $this->requestUrl . $this::XPAY_URI_RECURRING_3DS;
            }

            $curl = new CurlCall($url, $payLoad);

            $responseRaw = $curl->execCurl();

            $response = new ResponseNonce($responseRaw, $this->privateKey);

            $retResponse = $response->getResponse();

            if (!$response->isSuccess()) {
                Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));

                return [$res, $retResponse];
            }

            $res = true;
        } catch (ErrorCurlCall $exc) {
            Logger::logExceptionError($exc);
        } catch (Request $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));
        } catch (Response $exc) {
            Logger::logExceptionWarning($exc);
            Logger::logExceptionWarning(new \Exception('Payment error - ' . json_encode(['response' => $responseRaw])));
        }

        return [$res, $retResponse ?? null];
    }
}
