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

use Nexi\NPG\Build\NPGBuild;
use Nexi\NPG\Redirect\API;
use Nexi\Redirect\Error\NPG\PaymentInitialization;

class NexiXPayAjaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'npgBuildFields') {
            $this->ajaxNpgBuildFields();
        }
    }

    public function ajaxNpgBuildFields()
    {
        $res = [];

        try {
            $npgBuild = new NPGBuild($this->module);

            $payload = $npgBuild->getPayload($this->context);

            $api = new API();

            $response = $api->buildPayment($payload);

            $res = [
                'orderId' => $response['orderId'],
                'fields' => $response['fields'],
            ];
        } catch (PaymentInitialization $exc) {
            $res['error_msg'] = $this->module->l('Error while initializing the payment.', 'ajax');
        } catch (Exception $exc) {
            $res['error_msg'] = $this->module->l('Unable to initialize the payment.', 'ajax');
        }

        exit(json_encode($res));
    }
}
