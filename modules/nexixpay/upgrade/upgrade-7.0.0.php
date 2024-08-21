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
 * @version     7.0.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_0_0($module)
{
    if ($module->name != XPAY_MODULE_NAME) {
        return false;
    }

    if (!NexiXPay::isXPayRedirect() && !NexiXPay::isXPayBuild()) {
        \Nexi\Utility\Logger::logExceptionCritical(new Exception('Invalid plugin variant'));

        return false;
    }

    if (NexiXPay::isXPayBuild()) {
        \Configuration::updateValue('NEXIXPAY_ALIAS', \Configuration::get('NEXIXPAYBUILD_ALIAS'));
        \Configuration::updateValue('NEXIXPAY_MAC_KEY', \Configuration::get('NEXIXPAYBUILD_MAC_KEY'));
        \Configuration::updateValue('NEXIXPAY_ACCOUNTING', \Configuration::get('NEXIXPAYBUILD_ACCOUNTING'));
        \Configuration::updateValue('NEXIXPAY_LANGUAGE', \Configuration::get('NEXIXPAYBUILD_LANGUAGE'));
        \Configuration::updateValue('NEXIXPAY_TEST', \Configuration::get('NEXIXPAYBUILD_TEST'));
        \Configuration::updateValue('NEXIXPAY_ENABLE_ONECLICK', \Configuration::get('NEXIXPAYBUILD_ENABLE_ONECLICK'));
        \Configuration::updateValue('NEXIXPAY_ENABLE_3DSECURE', \Configuration::get('nexixpaybuild_enabled3ds'));

        \Configuration::deleteByName('NEXIXPAYBUILD_ALIAS');
        \Configuration::deleteByName('NEXIXPAYBUILD_MAC_KEY');
        \Configuration::deleteByName('NEXIXPAYBUILD_ACCOUNTING');
        \Configuration::deleteByName('NEXIXPAYBUILD_LANGUAGE');
        \Configuration::deleteByName('NEXIXPAYBUILD_TEST');
        \Configuration::deleteByName('NEXIXPAYBUILD_ENABLE_ONECLICK');
        \Configuration::deleteByName('nexixpaybuild_enabled3ds');
    }

    include_once dirname(__FILE__) . '/../sql/upgrade-7.0.0.php';

    $sql = [];

    $sql[] = '  CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'npg_payments_redirect (
                id INT(11) NOT NULL AUTO_INCREMENT,
                id_cart INT(10) NOT NULL,
                order_id VARCHAR(27) NOT NULL,
                security_token VARCHAR(64) NOT NULL,
                order_created BOOLEAN NOT NULL DEFAULT FALSE,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`) 
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

    foreach ($sql as $query) {
        if (Db::getInstance()->execute($query) == false) {
            return false;
        }
    }

    return true;
}
