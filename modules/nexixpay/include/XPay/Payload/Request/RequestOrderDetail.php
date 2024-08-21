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

class RequestOrderDetail extends Request
{
    private $transactionCode;

    public function __construct($apiKey, $privateKey, $transactionCode)
    {
        parent::__construct($apiKey, $privateKey);
        $this->transactionCode = $transactionCode;
    }

    public function getPayload()
    {
        $payLoad = parent::getPayload();
        unset($payLoad['mac']);
        $payLoad['codiceTransazione'] = $this->transactionCode;
        $payLoad['mac'] = $this->generateMac();

        return $payLoad;
    }

    private function generateMac()
    {
        return sha1('apiKey=' . $this->apiKey . 'codiceTransazione='
            . $this->transactionCode . 'timeStamp=' . $this->timestamp . $this->privateKey);
    }
}
