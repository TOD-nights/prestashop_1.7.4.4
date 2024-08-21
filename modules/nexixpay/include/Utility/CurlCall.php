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

namespace Nexi\Utility;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error;
use Nexi\Redirect\Error\CurlCall as ErrorCurlCall;

class CurlCall
{
    private $request_url;
    private $pay_load;

    public function __construct($request_url, $pay_load)
    {
        $this->request_url = $request_url;
        $this->pay_load = $pay_load;
    }

    public function execCurl()
    {
        $connection = curl_init();

        if (!$connection) {
            throw new ErrorCurlCall('Curl connection error');
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => $this->request_url,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode($this->pay_load),
            CURLOPT_RETURNTRANSFER => 1,
            CURLINFO_HEADER_OUT => true,
        ]);

        $response = curl_exec($connection);

        if ($response === false) {
            Logger::logExceptionError(new \Exception(json_encode(['url' => $this->request_url, 'pay_load' => $this->pay_load, 'response' => $response])));

            throw new Error\CurlCallConnection(curl_error($connection));
        }

        $curlInfo = curl_getinfo($connection);

        curl_close($connection);

        $json = json_decode($response, true);

        if ($curlInfo['http_code'] != '200') {
            Logger::logExceptionError(new \Exception(json_encode(['url' => $this->request_url, 'pay_load' => $this->pay_load, 'response' => $json])));

            throw new Error\CurlCallCode('Curl failed ' . $curlInfo['http_code']);
        }

        return $json;
    }

    /**
     * Undocumented function
     *
     * @param string $method "POST" - "GET"
     * @param string $request_url
     * @param array $pay_load
     * @param string $api_key
     *
     * @return void
     */
    public static function exec_REST_CURL($method, $request_url, $pay_load, $api_key, $extra_headers = [])
    {
        $connection = curl_init();

        if (!$connection) {
            throw new ErrorCurlCall('Curl connection error');
        }

        if ($method === 'GET') {
            $request_url = sprintf('%s?%s', $request_url, http_build_query($pay_load));
        } elseif ($method === 'POST') {
            curl_setopt($connection, CURLOPT_POST, 1);

            curl_setopt($connection, CURLOPT_POSTFIELDS, json_encode($pay_load));
        }

        $mod = \Module::getInstanceByName(XPAY_MODULE_NAME);

        $http_header = array_merge([
            'x-api-key: ' . $api_key,
            'x-plugin-name: Prestashop ' . \Tools::substr(_PS_VERSION_, 0, 3) . '.x - ' . $mod->name . ' ' . $mod->version,
            'Correlation-Id: ' . self::generateUuid(),
            'Content-Type: application/json',
        ], $extra_headers);

        $headers = [];

        curl_setopt_array($connection, [
            CURLOPT_URL => $request_url,
            CURLOPT_HTTPHEADER => $http_header,
            CURLOPT_RETURNTRANSFER => 1,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) { // ignore invalid headers
                    return $len;
                }

                $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                return $len;
            },
        ]);

        Logger::log(
            __FUNCTION__ . ': Request - ' . json_encode([
                'method' => $method,
                'requestUrl' => $request_url,
                'httpHeader' => array_splice($http_header, 1),
                'payload' => $pay_load,
                'extraHeaders' => $extra_headers,
            ]),
            1
        );

        $response = curl_exec($connection);

        if ($response === false) {
            Logger::logExceptionError(new \Exception(json_encode(['url' => $request_url, 'pay_load' => $pay_load, 'response' => $response])));

            throw new Error\CurlCallConnection(curl_error($connection));
        }

        $curlInfo = curl_getinfo($connection);

        curl_close($connection);

        $json = json_decode($response, true);

        if (
            array_key_exists('content-type', $headers)
            && $headers['content-type'] == 'application/json'
            && ($curlInfo['http_code'] == 200 || $curlInfo['http_code'] == 500)
            && !(is_array($json) && json_last_error() === JSON_ERROR_NONE)
        ) {
            Logger::logExceptionError(new \Exception(json_encode(['url' => $request_url, 'pay_load' => $pay_load, 'response' => $response, 'status' => $curlInfo['http_code']])));

            throw new \Exception('JSON error');
        }

        return [
            'status_code' => $curlInfo['http_code'],
            'response' => json_last_error() === JSON_ERROR_NONE ? $json : [],
        ];
    }

    /**
     * generates a uuid
     *
     * @return string
     */
    public static function generateUuid()
    {
        $uuid = substr(bin2hex(random_bytes(32)), 0, 32);

        return implode('-', [substr($uuid, 0, 8), substr($uuid, 8, 4), substr($uuid, 12, 4), substr($uuid, 16, 4), substr($uuid, 20, 12)]);
    }
}
