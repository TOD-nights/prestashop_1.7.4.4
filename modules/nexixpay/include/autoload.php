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
if (!defined('_PS_VERSION_')) {
    exit;
}

spl_autoload_register(function ($class) {
    $class_fliename = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (\Tools::substr($class_fliename, 0, 19) === 'Nexi' . DIRECTORY_SEPARATOR . 'XPay' . DIRECTORY_SEPARATOR . 'Redirect' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'XPay' . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 19);
    } elseif (\Tools::substr($class_fliename, 0, 18) === 'Nexi' . DIRECTORY_SEPARATOR . 'NPG' . DIRECTORY_SEPARATOR . 'Redirect' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'NPG' . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 18);
    } elseif (\Tools::substr($class_fliename, 0, 16) === 'Nexi' . DIRECTORY_SEPARATOR . 'XPay' . DIRECTORY_SEPARATOR . 'Build' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'XPay' . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 16);
    } elseif (\Tools::substr($class_fliename, 0, 15) === 'Nexi' . DIRECTORY_SEPARATOR . 'NPG' . DIRECTORY_SEPARATOR . 'Build' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'NPG' . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 15);
    } elseif (\Tools::substr($class_fliename, 0, 14) === 'Nexi' . DIRECTORY_SEPARATOR . 'Redirect' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 14);
    } elseif (\Tools::substr($class_fliename, 0, 13) === 'Nexi' . DIRECTORY_SEPARATOR . 'Utility' . DIRECTORY_SEPARATOR) {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Utility' . DIRECTORY_SEPARATOR . \Tools::substr($class_fliename, 13);
    }

    // Need for ps 1.6 compatibility Class without namespace for object model
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'XPay/PaymentInfo.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'XPay/XPayBuildContract.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'NPG/OrderInfo.php';
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'NPG/Contract.php';

    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'costant.php';

    $path = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));

    $path[count($path) - 1] = 'controllers';

    require_once implode(DIRECTORY_SEPARATOR, $path) . DIRECTORY_SEPARATOR . 'front/base.php';
});
