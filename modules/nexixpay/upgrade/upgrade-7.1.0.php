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
 * @version     7.1.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_1_0($module)
{
    if ($module->name == XPAY_MODULE_NAME) {
        $sql = [];

        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . 'npg_payments_redirect` 
                    ADD `session_id` VARCHAR(64) NULL DEFAULT NULL AFTER `security_token`;';

        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . 'npg_payments_redirect` 
                    ADD `p_started` BOOLEAN NOT NULL DEFAULT FALSE AFTER `session_id`;';

        $sql[] = '  RENAME TABLE `' . _DB_PREFIX_ . 'npg_payments_redirect` TO `' . _DB_PREFIX_ . 'npg_payments`;';

        foreach ($sql as $query) {
            if (Db::getInstance()->execute($query) == false) {
                return false;
            }
        }

        return true;
    }

    return false;
}
