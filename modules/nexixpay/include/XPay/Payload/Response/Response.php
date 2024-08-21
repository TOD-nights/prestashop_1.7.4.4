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

namespace Nexi\XPay\Redirect\Payload\Response;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\Response as ErrorResponse;

abstract class Response
{
    private $payLoad;
    private $privateKey;

    /**
     * Response constructor.
     *
     * @param $payLoad
     */
    public function __construct($payLoad, $privateKey)
    {
        $this->payLoad = $payLoad;
        $this->privateKey = $privateKey;
    }

    public function isSuccess()
    {
        return $this->payLoad['esito'] == 'OK';
    }

    public function getResponse()
    {
        return $this->payLoad;
    }

    protected function validateResponse()
    {
        $ResponseMac = sha1('esito=' . $this->payLoad['esito']
            . 'idOperazione=' . $this->payLoad['idOperazione'] . 'timeStamp='
            . $this->payLoad['timeStamp'] . $this->privateKey);

        if ($this->payLoad['mac'] != $ResponseMac) {
            throw new ErrorResponse('Invalid Response Mac');
        }
    }
}
