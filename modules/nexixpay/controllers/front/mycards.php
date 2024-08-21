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
use Nexi\Redirect\Settings;
use Nexi\Utility\Helper;
use Nexi\XPay\Build\XPayBuild;

class NexiXPayMyCardsModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $display_column_right = false;

    public function initContent()
    {
        parent::initContent();

        $this->setTemplate(Helper::get_front_template_path('myCards.tpl', 'myCards_17.tpl'));
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->addJS('/modules/' . $this->module->name . '/views/js/xpay_contract.js');
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();

        return $breadcrumb;
    }

    public function postProcess()
    {
        $cart = $this->context->cart;

        $config = Settings::getConfiguration();

        if (!$config['oneclick'] || !$this->context->customer->isLogged()) {
            Tools::redirect('index.php?controller=order');
        }

        $dati = [
            'oneClickEnabled' => $config['oneclick'],
            'title' => $this->module->l('Payment Cards'),
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int) $cart->id_currency),
            'total' => Tools::displayPrice(
                Helper::getTotalFromCart($cart),
                new Currency((int) $cart->id_currency)
            ),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . $this->module->name . '/',
        ];

        $hasContracts = false;
        $contracts = [];

        if (NexiXPay::isXPayBuild()) {
            $dati['paymentGateway'] = PG_XPAY;

            $contracts = XPayBuild::canPayByContract($cart->id_customer);

            $hasContracts = $contracts !== false && is_array($contracts) && count($contracts) > 0;
        } else {
            $dati['paymentGateway'] = PG_NPG;

            $npg = new NPG($this->module);

            $res = $npg->getOneClickSavedContracts($cart->id_customer);

            $hasContracts = $res['has_contracts'];
            $contracts = $res['contracts'];
        }

        if ($hasContracts) {
            $dati['canPayByContract'] = 1;
            $dati['contracts'] = $contracts;
            $dati['js_contracts'] = '/modules/' . $this->module->name . '/views/js/xpay_contract.js';
        }

        $this->context->smarty->assign($dati);
    }
}
