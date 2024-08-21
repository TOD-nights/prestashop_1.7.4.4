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

namespace Nexi\XPay\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Parameters
{
    public $apiKey;
    public $privateKey;
    public $enableOneclick;
    public $testMode;
    public $urlCashPage;
    public $urlEnv;
    public $urlProduction = 'https://ecommerce.nexi.it/';
    public $urlIntegration = 'https://int-ecommerce.nexi.it/';
    public $urlNotify;
    public $urlPost;
    public $url;
    public $urlBack;
    public $nexiUnique;
    public $accounting;
    public $fontSize;
    public $fontFamily;
    public $fontStyle;
    public $fontVariant;
    public $letterSpacing;
    public $borderColorDefault;
    public $borderColorError;
    public $textColorPlaceholder;
    public $textColorInput;
    public $buildEnv;
    public $buildIntegrationEnv = 'INTEG';
    public $buildProductionEnv = 'PROD';
}
