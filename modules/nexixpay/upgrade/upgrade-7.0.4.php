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
 * @version     7.0.4
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_0_4($module)
{
    if ($module->name == XPAY_MODULE_NAME) {
        $sql = [];

        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . 'npg_payments_redirect` 
                    ADD `token` VARCHAR(255) NULL DEFAULT NULL AFTER `created_at`;';

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
            if (Db::getInstance()->execute($query) == false) {
                return false;
            }
        }

        return true;
    }

    return false;
}
