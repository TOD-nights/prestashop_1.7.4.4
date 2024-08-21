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
if (!defined('_PS_VERSION_')) {
    exit;
}

$sql = [];

$sql[] = '  CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . "xpay_payments_info` (
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

if (NexiXPay::isXPayBuild()) {
    $sql[] = '  CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'xpay_contracts` (
                    `id_contract` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `id_customer` INT(10) UNSIGNED NOT NULL,
                    `num_contract` VARCHAR(30) NOT NULL,
                    `brand` VARCHAR(16) NOT NULL,
                    `pan` VARCHAR(16) NOT NULL,
                    `expiry_month` INT(10) UNSIGNED NOT NULL,
                    `expiry_year` INT(10) UNSIGNED NOT NULL
                ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';
}

$sql[] = '  CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'npg_payments (
                id INT(11) NOT NULL AUTO_INCREMENT,
                id_cart INT(10) NOT NULL,
                order_id VARCHAR(27) NOT NULL,
                security_token VARCHAR(64) NOT NULL,
                session_id VARCHAR(64) NULL DEFAULT NULL,
                p_started BOOLEAN NOT NULL DEFAULT FALSE,
                order_created BOOLEAN NOT NULL DEFAULT FALSE,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                token VARCHAR(255) NULL DEFAULT NULL,
                lock_validate BOOLEAN NOT NULL DEFAULT FALSE,
                PRIMARY KEY (`id`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

$sql[] = '  CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'npg_contracts` (
                id INT(11) NOT NULL AUTO_INCREMENT,
                id_customer INT(10) UNSIGNED NOT NULL,
                num_contract VARCHAR(255) NOT NULL,
                brand VARCHAR(16) NOT NULL,
                pan VARCHAR(16) NOT NULL,
                expiry_month INT(10) UNSIGNED NOT NULL,
                expiry_year INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) === false) {
        return false;
    }
}
