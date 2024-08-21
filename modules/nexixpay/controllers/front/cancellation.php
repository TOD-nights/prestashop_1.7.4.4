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

class NexiXPayCancellationModuleFrontController extends NexiXPayBaseModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $dati = Tools::getAllValues();

        if ($dati['esito'] == 'ERRORE' && strpos($dati['warning'], 'deliveryMethod') !== false) {
            $error = $this->module->l('It was not possible to process the payment, check that the shipping address set is correct.', 'cancellation');

            $this->redirectToErrorPage($error);
        } else {
            $this->redirectToCancelPage();
        }
    }
}
