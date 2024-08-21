<?php
/**
 * 2007-2023 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2023 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\Bonaicontent\Api;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Request
{
    /**
     * @var string
     */
    private $shopUuid;

    public function __construct($shopUuid)
    {
        $this->shopUuid = $shopUuid;
    }

    public function sendRequest($data = [])
    {
        $url = $data['url'];

        return $this->callModuleApi($url, $data);
    }

    public function callModuleApi($url, $data)
    {
        $token = $this->shopUuid;

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Base ' . base64_encode($token),
        ];

        $data = http_build_query($data);

        $curlInfo = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_TIMEOUT => 180,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, $curlInfo);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->handleResponseContent($response);
    }

    private function handleResponseContent($response)
    {
        $response = json_decode($response, true);
        if (!is_array($response)) {
            return [
                'success' => false,
                'error' => [
                    'message' => 'Unknown response',
                ],
            ];
        }

        return $response;
    }
}
