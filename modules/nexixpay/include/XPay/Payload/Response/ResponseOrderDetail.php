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

class ResponseOrderDetail extends Response
{
    public function __construct($payLoad, $privateKey)
    {
        parent::__construct($payLoad, $privateKey);
        $this->validateResponse();
    }
}
