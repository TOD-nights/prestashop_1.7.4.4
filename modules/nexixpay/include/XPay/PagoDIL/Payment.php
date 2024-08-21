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
 * @version     5.4.0
 */

namespace Nexi\XPay\Redirect\PagoDIL;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\CapToStateCode;
use Nexi\Redirect\Iso3166Conversion;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Logger;
use Nexi\XPay\Redirect\PagoDIL\Configuration as PagoDILConfiguration;

class Payment
{
    private $module;
    private $cart;
    private $customer;
    private $shippingAddress;
    private $billingAddress;
    private $numberOfInstalment;

    public function __construct($module, $cart)
    {
        $this->module = $module;
        $this->cart = $cart;

        $this->shippingAddress = new \Address((int) $this->cart->id_address_delivery);
        $this->billingAddress = new \Address((int) $this->cart->id_address_invoice);
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function setNumberOfInstalments($number)
    {
        $this->numberOfInstalment = $number;
    }

    public function getParams()
    {
        $params = [];

        $pagoDIL = new PagoDILConfiguration($this->module);
        $pagoDILConfiguration = $pagoDIL->getConfiguration();

        $params['nome'] = $this->customer->firstname;
        $params['cognome'] = $this->customer->lastname;
        $params['numberOfInstalment'] = $this->numberOfInstalment;

        $taxCode = $this->getTaxCode($pagoDILConfiguration);
        if ($taxCode !== null) {
            $params['OPTION_CF'] = $taxCode;
        }

        if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_PRODUCT_CODE'] != '') {
            $params['pagodilOfferID'] = $pagoDILConfiguration['NEXIXPAY_PAGODIL_PRODUCT_CODE'];
        }

        $cartProducts = $this->cart->getProducts();

        $params['itemsNumber'] = count($cartProducts);

        foreach ($cartProducts as $key => $item) {
            $params['Item_code_' . ($key + 1)] = $item['id_product'];
            $params['Item_quantity_' . ($key + 1)] = $item['cart_quantity'];
            $params['Item_amount_' . ($key + 1)] = CurrencyHelper::calculateAmountToMinUnitXPay(
                $item['price_wt'],
                CurrencyHelper::getCurrencyISOCode($this->cart->id_currency)
            );
            $params['Item_description_' . ($key + 1)] = $item['name'];
        }

        $params['shipIndicator'] = $this->getShipIndicator();

        if ($this->shippingAddress) {
            $phone = $this->getPhoneNumber();
            if ($phone !== null) {
                $params['Buyer_msisdn'] = $phone;
            }

            $params['Dest_street'] = $this->shippingAddress->address1;
            $params['Dest_city'] = $this->shippingAddress->city;
            $params['Dest_state'] = CapToStateCode::getStateCode($this->shippingAddress->postcode) ?? '';
            $params['Dest_cap'] = $this->shippingAddress->postcode;
            $params['Dest_country'] = Iso3166Conversion::getAlpha3($this->getISO3Code($this->shippingAddress->id_country));
        }

        if ($this->billingAddress) {
            $params['Bill_street'] = $this->billingAddress->address1;
            $params['Bill_city'] = $this->billingAddress->city;
            $params['Bill_state'] = CapToStateCode::getStateCode($this->billingAddress->postcode) ?? '';
            $params['Bill_cap'] = $this->billingAddress->postcode;
            $params['Bill_country'] = Iso3166Conversion::getAlpha3($this->getISO3Code($this->billingAddress->id_country));
        }

        return $params;
    }

    public function getShipIndicator()
    {
        if ($this->shippingAddress === null) {
            return '05';
        }

        if (
            $this->shippingAddress->city == $this->billingAddress->city
            && $this->getISO3Code($this->shippingAddress->id_country) == $this->getISO3Code($this->billingAddress->id_country)
            && $this->shippingAddress->address1 == $this->billingAddress->address1
            && $this->shippingAddress->postcode == $this->billingAddress->postcode
        ) {
            return '01';
        } else {
            return '03';
        }
    }

    private function getISO3Code($idCountry)
    {
        $country = new \Country($idCountry);

        return $country->iso_code;
    }

    private function getPhoneNumber()
    {
        if ($this->shippingAddress->phone != '') {
            $phone = $this->shippingAddress->phone;
        } elseif ($this->shippingAddress->phone_mobile != '') {
            $phone = $this->shippingAddress->phone_mobile;
        }

        if (isset($phone)) {
            $phone = trim($phone);

            if (strpos($phone, '+') === false) {
                $phone = '+39' . $phone;
            }

            if ($phone[3] == '3') {
                return $phone;
            }
        }

        return null;
    }

    /**
     * checks if taxcode input is setted in config and trys to retrive it from the avaiable data objects
     *
     * @param array $pagoDILConfiguration
     *
     * @return string|null
     */
    private function getTaxCode($pagoDILConfiguration)
    {
        if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR'] != '') {
            if (isset($this->shippingAddress) && property_exists($this->shippingAddress, $pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR'])) {
                return $this->shippingAddress->{$pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR']};
            }

            if (isset($this->customer) && property_exists($this->customer, $pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR'])) {
                return $this->customer->{$pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR']};
            }

            Logger::logExceptionWarning(new \Exception('Configuration tax code field (' . $pagoDILConfiguration['NEXIXPAY_PAGODIL_TAX_CODE_VAR'] . ') not found.'));
        }

        return null;
    }
}
