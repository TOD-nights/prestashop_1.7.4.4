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

updateConfiguration();
installTab();

function updateConfiguration()
{
    Configuration::updateValue('NEXIXPAY_TEST', 0);
    Configuration::updateValue('NEXIXPAY_UNIQUE', uniqid());
}

/**
 * Install Tab
 *
 * @return bool
 */
function installTab()
{
    $tab = new Tab();
    $tab->id_parent = -1;
    $tab->class_name = 'AdminNexiXPay';
    $tab->module = XPAY_MODULE_NAME;
    $tab->active = 1;
    $tab->name = [];

    foreach (Language::getLanguages(true) as $lang) {
        $tab->name[$lang['id_lang']] = 'Nexi XPay';
    }

    return $tab->add();
}
