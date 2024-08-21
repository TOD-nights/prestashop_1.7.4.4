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
 * @version     5.3.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\NPG\Redirect\NPG;
use Nexi\XPay\Redirect\XPay;

class AdminNexiXPayController extends ModuleAdminController
{
    /**
     * Ajax call for Accounting from Back office
     */
    public function ajaxProcessAccounting()
    {
        $ret = null;

        if (\Validate::isString(\Tools::getValue('id_order')) && \Validate::isString(\Tools::getValue('amount'))) {
            if (\Tools::getValue('gateway') == PG_NPG) {
                $npg = new NPG($this->module);

                $ret = $npg->account(\Tools::getValue('id_order'), \Tools::getValue('amount'));
            } elseif (\Tools::getValue('gateway') == PG_XPAY) {
                $xpay = new XPay($this->module);

                $ret = $xpay->account(\Tools::getValue('id_order'), \Tools::getValue('amount'));
            }
        }

        echo json_encode($ret);
    }

    /**
     * Ajax call for Refunding from Back office
     */
    public function ajaxProcessRefunding()
    {
        $ret = null;

        if (\Validate::isString(\Tools::getValue('id_order')) && \Validate::isString(\Tools::getValue('amount'))) {
            if (\Tools::getValue('gateway') == PG_NPG) {
                $npg = new NPG($this->module);

                $ret = $npg->refund(\Tools::getValue('id_order'), \Tools::getValue('amount'));
            } elseif (\Tools::getValue('gateway') == PG_XPAY) {
                $xpay = new XPay($this->module);

                $ret = $xpay->refund(\Tools::getValue('id_order'), \Tools::getValue('amount'));
            }
        }

        echo json_encode($ret);
    }
}
