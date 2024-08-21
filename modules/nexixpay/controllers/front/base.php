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

use Nexi\Utility\Helper;

class NexiXPayBaseModuleFrontController extends ModuleFrontController
{
    private function redirectToPage($template, $template_1_7, $dati = [])
    {
        $this->context->smarty->assign($dati);

        $this->setTemplate(Helper::get_front_template_path($template, $template_1_7));
    }

    public function redirectToErrorPage($error)
    {
        $this->redirectToPage('payment_error.tpl', 'payment_error_17.tpl', ['error' => $error]);
    }

    public function redirectToCancelPage()
    {
        $this->redirectToPage('payment_cancel.tpl', 'payment_cancel_17.tpl');
    }
}
