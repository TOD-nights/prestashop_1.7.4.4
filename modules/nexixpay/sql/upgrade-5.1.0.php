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

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'xpay_payments_redirect` (
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
                    PRIMARY KEY (`codTrans`)
                  ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=UTF8;';

$sql[] = 'REPLACE INTO `' . _DB_PREFIX_ . 'xpay_payments_redirect`(
            `codTrans`, `idCart`, `amount`, `currency`, `brand`, `result`, 
            `date`, `autCode`, `pan`, `exp`, `nationality`, `firstName`, 
            `lastName`, `mail`, `message`, `contractNumber`) 
            (SELECT `codTrans` as `codTrans`, `id_cart` as `idCart`, 
            `importo` as `amount`, `divisa` as `currency`, `brand` as `brand`, 
            `esito` as `result`, `data` as `date`, `codAut` as `autCode`, `pan` as `pan`, 
            `scadenza_pan` as `exp`, `nazionalita` as `nationality`, `nome` as `firstName`, 
            `cognome` as `lastName`, `mail` as `mail`, `messaggio` as `message`, `num_contratto` 
            as `contractNumber` FROM `' . _DB_PREFIX_ . 'xpay_payments`);';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
