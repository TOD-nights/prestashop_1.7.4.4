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
 * @version     7.1.6
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_7_1_5($module)
{
    if ($module->name == XPAY_MODULE_NAME) {
        $sql = [];

        if (NexiXPay::isXPayRedirect()) {
            try {
                if (Db::getInstance()->execute('SELECT * FROM `' . _DB_PREFIX_ . 'xpay_payments_redirect`;') !== false) {
                    if (Db::getInstance()->execute('SELECT * FROM `' . _DB_PREFIX_ . 'xpay_payments_info`;') !== false) {
                        $sql[] = '
                            INSERT INTO
                                `' . _DB_PREFIX_ . "xpay_payments_info` (
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
                                xp.idCart,
                                xp.amount,
                                xp.currency,
                                xp.brand,
                                xp.result,
                                xp.date,
                                xp.autCode,
                                xp.pan,
                                xp.exp,
                                xp.nationality,
                                xp.firstName,
                                xp.lastName,
                                xp.mail,
                                xp.message,
                                xp.contractNumber,
                                'redirect'
                            FROM
                                `" . _DB_PREFIX_ . 'xpay_payments_redirect` AS xp
                            WHERE
                                xp.codTrans NOT IN (
                                    SELECT
                                        codTrans
                                    FROM
                                        `' . _DB_PREFIX_ . 'xpay_payments_info`
                                );';

                        $sql[] = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'xpay_payments_redirect`;';
                    } else {
                        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . 'xpay_payments_redirect` RENAME TO `' . _DB_PREFIX_ . 'xpay_payments_info`;';

                        $sql[] = '  ALTER TABLE `' . _DB_PREFIX_ . "xpay_payments_info` 
                                    ADD `moduleVariant` ENUM('redirect','build','build-old') NULL AFTER `contractNumber`;";

                        $sql[] = '  UPDATE `' . _DB_PREFIX_ . "xpay_payments_info`
                                    SET `moduleVariant` = 'redirect';";
                    }
                }
            } catch (\Exception $e) {
                // table rename has already been done
            }
        }

        foreach ($sql as $query) {
            if (Db::getInstance()->execute($query) === false) {
                return false;
            }
        }

        return true;
    }

    return false;
}
