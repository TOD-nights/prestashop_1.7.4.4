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

class Image
{
    private $logoSmall;
    private $logoLarge;
    private $apiKey;
    private $privateKey;
    private $pluginVersion;
    private $platform;
    private $platformVersion;
    private $avaiableMethods;

    public function __construct(
        $avaiableMethods,
        $logoSmall,
        $logoLarge,
        $apiKey,
        $privateKey,
        $pluginVersion,
        $platform,
        $platformVersion
    ) {
        $this->avaiableMethods = $avaiableMethods;
        $this->logoSmall = $logoSmall;
        $this->logoLarge = $logoLarge;
        $this->apiKey = $apiKey;
        $this->privateKey = $privateKey;
        $this->pluginVersion = $pluginVersion;
        $this->platform = $platform;
        $this->platformVersion = $platformVersion;
    }

    public function getImgList($type = null)
    {
        $avaiableMethods = json_decode($this->avaiableMethods, true);
        $imgList = [];
        if (is_array($avaiableMethods)) {
            foreach ($avaiableMethods as $count => $am) {
                if ($type == null || $am['type'] == $type) {
                    if ($am['type'] == 'CC') {
                        $index = 10 + $count;
                    } else {
                        $index = 100 + $count;
                    }
                    $imgList[$index]['url'] = $am['image'];
                    $imgList[$index]['style'] = self::getImgStyle($am['code']);
                }
            }
        }

        return $imgList;
    }

    public static function getImgStyle($code)
    {
        $configuration = [
            'maestro' => 'padding-right:10px !important; padding-top:6px !important; padding-bottom:6px !important;',
            'mastercard' => 'padding-right:10px !important; padding-top:6px !important;'
                . ' padding-bottom:6px !important;',
            'visa' => 'padding-right:10px !important; padding-top:9px !important; padding-bottom:9px !important;',
            'paypal' => 'padding-right:14px !important; padding-top:10px !important; padding-bottom:10px !important;',
            'sofort' => 'padding-right:15px !important; padding-top:8px !important; padding-bottom:8px !important;',
            'amazonpay' => 'padding-right:15px !important; padding-top:8px !important;' .
                ' padding-bottom:8px !important;',
            'googlepay' => 'padding-right:14px !important; padding-top:9px !important;'
                . ' padding-bottom:9px;width:70px !important;',
            'alipay' => 'padding-right:10px !important; padding-top:6px !important; padding-bottom:0px !important;',
            'wechatpay' => 'padding-right:10px !important; padding-top:6px !important;' .
                ' padding-bottom:6px !important;',
            'masterpass' => 'padding-right:13px !important; padding-top:8px !important;'
                . ' padding-bottom:8px !important;',
            'applepay' => 'padding-right:15px !important; padding-top:8px !important; padding-bottom:8px !important;',
            'nexi' => 'padding-right:15px !important; padding-top:10px !important; padding-bottom:10px !important;',
            'smallpay' => 'padding-right:15px !important; padding-top:8px !important; padding-bottom:3px !important;',
        ];

        if (isset($configuration[\Tools::strtolower($code)])) {
            return $configuration[\Tools::strtolower($code)];
        }

        return '';
    }

    public function getLogoNexiWithParameters($size = 'S')
    {
        $logo = $this->logoSmall;
        if ($size == 'L') {
            $logo = $this->logoLarge;
        }
        if (!isset($logo) || $logo == '') {
            $logo = '/modules/' . XPAY_MODULE_NAME . '/views/img/logo.jpg';
        }

        $timeStamp = time() * 1000;

        $mac = sha1('apiKey=' . $this->apiKey . 'timeStamp=' . $timeStamp
            . 'chiaveSegreta=' . $this->privateKey);

        $logo .= '?platform=' . $this->platform . '&'
            . 'platformVers=' . $this->platformVersion . '&'
            . 'pluginVers=' . $this->pluginVersion . '&mac=' . $mac;

        return $logo;
    }
}
