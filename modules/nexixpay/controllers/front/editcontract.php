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

class NexiXPayEditcontractModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $oXPayToken = new XPayBuildContract();

        echo json_encode($oXPayToken->updateContract($_REQUEST['id_contract'], $_REQUEST['month'], $_REQUEST['year']));
        exit;
    }
}