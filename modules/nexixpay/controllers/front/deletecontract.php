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
 * @version     7.0.0
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\NPG\Redirect\NPG;

class NexiXPayDeletecontractModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        if (NexiXPay::isXPayBuild()) {
            $oXPayToken = new XPayBuildContract();

            $ret = ['res' => true];

            if ($oXPayToken->deleteContract($this->context->cart->id_customer, Tools::getValue('id_contract'))) {
                $ret['msg'] = 'Eliminato';
            } else {
                $ret['msg'] = "Errore durante l'eliminazione - " . $this->context->cart->id_customer . ' - ' . Tools::getValue('id_contract');
            }

            echo json_encode($ret);
            exit;
        } else {
            echo json_encode((new NPG($this->module))->deleteContract($this->context->cart->id_customer, Tools::getValue('id_contract')));
            exit;
        }
    }
}
