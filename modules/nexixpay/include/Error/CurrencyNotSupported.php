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

namespace Nexi\Redirect\Error;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CurrencyNotSupported extends NexiError
{
    public function __construct($currency)
    {
        parent::__construct('Currency not supported: ' . json_encode($currency));
    }
}
