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

class RequestAvailableMethods extends Request
{
    private $platform;
    private $platformVersion;
    private $pluginVersion;

    public function __construct($apiKey, $privateKey, $platform, $platformVersion, $pluginVersion)
    {
        parent::__construct($apiKey, $privateKey);
        $this->platform = $platform;
        $this->platformVersion = $platformVersion;
        $this->pluginVersion = $pluginVersion;
    }

    public function getPayload()
    {
        $payLoad = parent::getPayload();
        $payLoad['platform'] = $this->platform;
        $payLoad['platformVers'] = $this->platformVersion;
        $payLoad['pluginVers'] = $this->pluginVersion;

        return $payLoad;
    }
}
