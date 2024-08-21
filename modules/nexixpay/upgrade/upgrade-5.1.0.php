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

function upgrade_module_5_1_0($module)
{
    if ($module->name == XPAY_MODULE_NAME) {
        if (\Configuration::get('enabled3ds') && \Configuration::get('enabled3ds') != '') {
            \Configuration::updateValue('NEXIXPAY_ENABLE_3DSECURE', \Configuration::get('enabled3ds'));
            \Configuration::deleteByName('enabled3ds');
        }
        if (!(\Configuration::get('NEXIXPAY_UNIQUE') && \Configuration::get('NEXIXPAY_UNIQUE') != '')) {
            Configuration::updateValue('NEXIXPAY_UNIQUE', uniqid());
        }
        include_once dirname(__FILE__) . '/../sql/upgrade-5.1.0.php';

        return true;
    }

    return false;
}
