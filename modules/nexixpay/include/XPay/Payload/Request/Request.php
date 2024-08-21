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
 * @version     5.1.0
 */

namespace Nexi\XPay\Redirect\Payload\Request;

if (!defined('_PS_VERSION_')) {
    exit;
}

abstract class Request
{
    protected $apiKey;
    protected $privateKey;
    protected $timestamp;

    public function __construct($apiKey, $privateKey)
    {
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->timestamp = time() * 1000;
    }

    public function getPayload()
    {
        return [
            'apiKey' => $this->apiKey,
            'timeStamp' => (string) $this->timestamp,
            'mac' => $this->generateMac(),
        ];
    }

    private function generateMac()
    {
        return sha1('apiKey=' . $this->apiKey . 'timeStamp=' . $this->timestamp . $this->privateKey);
    }
}
