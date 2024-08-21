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

uninstall();
uninstallTab();

function uninstall()
{
    Configuration::deleteByName('NEXIXPAY_ACCOUNTING');
    Configuration::deleteByName('NEXIXPAY_ENABLE_ONECLICK');
    Configuration::deleteByName('NEXIXPAY_AVAILABLE_METHODS');
    Configuration::deleteByName('NEXIXPAY_LOGO_SMALL');
    Configuration::deleteByName('NEXIXPAY_LOGO_LARGE');
    Configuration::deleteByName('NEXIXPAY_UNIQUE');
    Configuration::deleteByName('NEXIXPAY_TEST');
    Configuration::deleteByName('NEXIXPAY_ALIAS');
    Configuration::deleteByName('NEXIXPAY_MAC_KEY');
    Configuration::deleteByName('NEXIXPAY_ENABLED_GATEWAY');
    Configuration::deleteByName('NEXINPG_API_KEY');
    Configuration::deleteByName('NEXIXPAY_ENABLE_3DSECURE');
    Configuration::deleteByName('NEXINPG_ENABLE_MULTICURRENCY');
    Configuration::deleteByName('NEXIXPAY_PAGODIL');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_PRODUCT_CODE');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_ENABLED_CATEGORIES');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_TAX_CODE_VAR');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_LINK');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_PRODUCT_LIMIT');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_SHOW_WIDGET');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_INS_NUMBER');
    Configuration::deleteByName('NEXIXPAY_PAGODIL_LOGO_KIND');
    Configuration::deleteByName('NEXIXPAYBUILD_FONT_FAMILY');
    Configuration::deleteByName('NEXIXPAYBUILD_FONT_SIZE');
    Configuration::deleteByName('NEXIXPAYBUILD_FONT_STYLE');
    Configuration::deleteByName('NEXIXPAYBUILD_FONT_VARIANT');
    Configuration::deleteByName('NEXIXPAYBUILD_LETTER_SPACING');
    Configuration::deleteByName('NEXIXPAYBUILD_BORDER_COLOR_DEFAULT');
    Configuration::deleteByName('NEXIXPAYBUILD_BORDER_COLOR_ERROR');
    Configuration::deleteByName('NEXIXPAYBUILD_TEXT_COLOR_PLACEHOLDER');
    Configuration::deleteByName('NEXIXPAYBUILD_TEXT_COLOR_INPUT');
}

/**
 * Uninstall Tab
 *
 * @return bool
 */
function uninstallTab()
{
    $id_tab = (int) Tab::getIdFromClassName('AdminNexiXPay');
    if ($id_tab) {
        $tab = new Tab($id_tab);
        if (Validate::isLoadedObject($tab)) {
            return $tab->delete();
        } else {
            return false;
        }
    } else {
        return true;
    }
}
