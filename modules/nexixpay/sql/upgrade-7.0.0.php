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

$sql = [];

if (NexiXPay::isXPayRedirect()) {
    $sql[] = '
        ALTER TABLE `' . _DB_PREFIX_ . 'xpay_payments_redirect` RENAME TO `' . _DB_PREFIX_ . 'xpay_payments_info`;';

    $sql[] = '  
        ALTER TABLE `' . _DB_PREFIX_ . "xpay_payments_info` 
        ADD `moduleVariant` ENUM('redirect','build','build-old') NULL AFTER `contractNumber`;";

    $sql[] = '
        UPDATE `' . _DB_PREFIX_ . "xpay_payments_info`
        SET `moduleVariant` = 'redirect';";
} elseif (NexiXPay::isXPayBuild()) {
    $sql[] = '  
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . "xpay_payments_info` (
            `codTrans` char(64) NOT NULL,
            `idCart` INT(11) NOT NULL,
            `amount` decimal(10,2) DEFAULT NULL,
            `currency` varchar(8) DEFAULT NULL,
            `brand` varchar(128) DEFAULT NULL,
            `result` varchar(8) DEFAULT NULL,
            `date` datetime DEFAULT NULL,
            `autCode` varchar(8) DEFAULT NULL,
            `pan` varchar(16) DEFAULT NULL,
            `exp` varchar(8) DEFAULT NULL,
            `nationality` varchar(8) DEFAULT NULL,
            `firstName` varchar(256) DEFAULT NULL,
            `lastName` varchar(256) DEFAULT NULL,
            `mail` varchar(256) DEFAULT NULL,
            `message` varchar(256) DEFAULT NULL,
            `contractNumber` VARCHAR(128) DEFAULT NULL,
            `moduleVariant` ENUM('redirect','build','build-old') NULL,
            PRIMARY KEY (`codTrans`)
        ) ENGINE=" . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

    // data migration from old build plugin

    $checkTable = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_NAME = '" . _DB_PREFIX_ . "xpay_payments';";

    $res = Db::getInstance()->executeS($checkTable);

    if ($res && is_array($res) && count($res) > 0) {
        $sql[] = '
            INSERT INTO `' . _DB_PREFIX_ . "xpay_payments_info` (
                `codTrans`,
                `idCart`,
                `amount`,
                `currency`,
                `brand`,
                `result`,
                `date`,
                `autCode`,
                `pan`,
                `exp`,
                `nationality`,
                `firstName`,
                `lastName`,
                `mail`,
                `message`,
                `contractNumber`,
                `moduleVariant`
            )
            SELECT 
                xp.codTrans,
                xp.id_cart,
                xp.importo,
                xp.divisa,
                xp.brand,
                xp.esito,
                xp.data,
                xp.codAut,
                xp.pan,
                xp.scadenza_pan,
                xp.nazionalita,
                xp.nome,
                xp.cognome,
                xp.mail,
                xp.messaggio,
                xp.num_contratto,
                'build-old'
            FROM `" . _DB_PREFIX_ . 'xpay_payments` AS xp';

        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'xpay_payments`;';
    }

    $sql[] = '
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'xpay_contracts` (
            `id_contract` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_customer` INT(10) UNSIGNED NOT NULL,
            `num_contract` VARCHAR(30) NOT NULL,
            `brand` VARCHAR(16) NOT NULL,
            `pan` VARCHAR(16) NOT NULL,
            `expiry_month` INT(10) UNSIGNED NOT NULL,
            `expiry_year` INT(10) UNSIGNED NOT NULL
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';
}

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
