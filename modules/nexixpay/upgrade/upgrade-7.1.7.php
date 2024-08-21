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
 * @version     7.1.7
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_1_7($module)
{
    if ($module->name == XPAY_MODULE_NAME) {
        $sql = [];

        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . "npg_payments` 
                    ADD `lock_validate` BOOLEAN NOT NULL DEFAULT FALSE AFTER `token`;";

        foreach ($sql as $query) {
            if (Db::getInstance()->execute($query) === false) {
                return false;
            }
        }

        return true;
    }

    return false;
}
