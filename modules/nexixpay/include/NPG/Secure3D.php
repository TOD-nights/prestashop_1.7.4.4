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

namespace Nexi\NPG\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\CapToStateCode;
use Nexi\Redirect\Iso3166Conversion;

class Secure3D
{
    private $cart;
    private $customer;
    private $shippingAddress;
    private $billingAddress;

    public function __construct($cart, $customer)
    {
        $this->cart = $cart;
        $this->customer = $customer;
        $this->shippingAddress = new \Address((int) $this->cart->id_address_delivery);
        $this->billingAddress = new \Address((int) $this->cart->id_address_invoice);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $dati = [];

        $dati = [
            'cardHolderName' => trim(($this->customer->firstname ?? '') . ' ' . ($this->customer->lastname ?? '')),
            'cardHolderEmail' => $this->customer->email,
        ];

        if ($this->shippingAddress->phone_mobile != '') {
            $dati['mobilePhone'] = $this->shippingAddress->phone_mobile;
        }

        if ($this->shippingAddress->phone != '' && preg_match('/^(\+)([0-9]{10,15})$/', $this->shippingAddress->phone)) {
            $dati['homePhone'] = $this->shippingAddress->phone;
        }

        if ($this->shippingAddress) {
            $shippingAddress = [];

            if ($this->shippingAddress->firstname || $this->shippingAddress->lastname) {
                $shippingAddress['name'] = trim(($this->shippingAddress->firstname ?? '') . ' ' . ($this->shippingAddress->lastname ?? ''));
            }

            if ($this->shippingAddress->address1) {
                $shippingAddress['street'] = $this->shippingAddress->address1;
            }

            if ($this->shippingAddress->address2) {
                $shippingAddress['additionalInfo'] = $this->shippingAddress->address2;
            }

            if ($this->shippingAddress->city) {
                $shippingAddress['city'] = $this->shippingAddress->city;
            }

            if ($this->shippingAddress->postcode) {
                $shippingAddress['postCode'] = $this->shippingAddress->postcode;
            }

            if (CapToStateCode::getStateCode($this->shippingAddress->postcode)) {
                $shippingAddress['province'] = CapToStateCode::getStateCode($this->shippingAddress->postcode);
            }

            if (Iso3166Conversion::getAlpha3(\Country::getIsoById($this->shippingAddress->id_country))) {
                $shippingAddress['country'] = Iso3166Conversion::getAlpha3(\Country::getIsoById($this->shippingAddress->id_country));
            }

            if (count($shippingAddress) > 0) {
                $dati['shippingAddress'] = $shippingAddress;
            }
        }

        if ($this->billingAddress) {
            $billingAddress = [];

            if ($this->billingAddress->firstname || $this->billingAddress->lastname) {
                $billingAddress['name'] = trim(($this->billingAddress->firstname ?? '') . ' ' . ($this->billingAddress->lastname ?? ''));
            }

            if ($this->billingAddress->address1) {
                $billingAddress['street'] = $this->billingAddress->address1;
            }

            if ($this->billingAddress->address2) {
                $billingAddress['additionalInfo'] = $this->billingAddress->address2;
            }

            if ($this->billingAddress->city) {
                $billingAddress['city'] = $this->billingAddress->city;
            }

            if ($this->billingAddress->postcode) {
                $billingAddress['postCode'] = $this->billingAddress->postcode;
            }

            if (CapToStateCode::getStateCode($this->billingAddress->postcode)) {
                $billingAddress['province'] = CapToStateCode::getStateCode($this->billingAddress->postcode);
            }

            if (Iso3166Conversion::getAlpha3(\Country::getIsoById($this->billingAddress->id_country))) {
                $billingAddress['country'] = Iso3166Conversion::getAlpha3(\Country::getIsoById($this->billingAddress->id_country));
            }

            if (count($billingAddress) > 0) {
                $dati['billingAddress'] = $billingAddress;
            }
        }

        if ($this->getChAccDate($this->customer) != '') {
            $dati['cardHolderAcctInfo']['chAccDate'] = $this->getChAccDate($this->customer);
        }

        if ($this->getAccountDateIndicator($this->customer->date_add) != '') {
            $dati['cardHolderAcctInfo']['chAccAgeIndicator'] = $this->getAccountDateIndicator($this->customer->date_add);
        }

        if ($this->getChAccDate($this->customer) != '') {
            $dati['cardHolderAcctInfo']['chAccChangeDate'] = $this->getChAccChangeDate($this->customer);
        }

        if ($this->getDateIndicator($this->customer->date_upd) != '') {
            $dati['cardHolderAcctInfo']['chAccChangeIndicator'] = $this->getDateIndicator($this->customer->date_upd);
        }

        if ($this->getOrderInLastSixMonth() != '') {
            $dati['cardHolderAcctInfo']['nbPurchaseAccount'] = $this->getOrderInLastSixMonth();
        }

        if ($this->getLastUsagedestinationAddress(
            $this->shippingAddress->city,
            $this->shippingAddress->country,
            $this->shippingAddress->address1,
            $this->shippingAddress->address2,
            $this->shippingAddress->postcode,
            \State::getNameById($this->shippingAddress->id_state)
        ) != '') {
            $dati['cardHolderAcctInfo']['destinationAddressUsageDate'] = $this->getLastUsagedestinationAddress(
                $this->shippingAddress->city,
                $this->shippingAddress->country,
                $this->shippingAddress->address1,
                $this->shippingAddress->address2,
                $this->shippingAddress->postcode,
                \State::getNameById($this->shippingAddress->id_state)
            );
        }

        if ($this->getDateIndicator($this->getFirstUsagedestinationAddress(
            $this->shippingAddress->city,
            $this->shippingAddress->country,
            $this->shippingAddress->address1,
            $this->shippingAddress->address2,
            $this->shippingAddress->postcode,
            \State::getNameById($this->shippingAddress->id_state)
        )) != '') {
            $dati['cardHolderAcctInfo']['destinationAddressUsageIndicator'] = $this->getDateIndicator(
                $this->getFirstUsagedestinationAddress(
                    $this->shippingAddress->city,
                    $this->shippingAddress->country,
                    $this->shippingAddress->address1,
                    $this->shippingAddress->address2,
                    $this->shippingAddress->postcode,
                    \State::getNameById($this->shippingAddress->id_state)
                )
            );
        }

        if ($this->checkName($this->billingAddress->firstname, $this->billingAddress->lastname) != '') {
            $dati['cardHolderAcctInfo']['destinationNameIndicator'] = $this->checkName(
                $this->billingAddress->firstname,
                $this->billingAddress->lastname
            );
        }

        return $dati;
    }

    private function getChAccDate($customer)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $customer->date_add);

        if ($date) {
            return $date->format('Y-m-d');
        }
    }

    private function getAccountDateIndicator($date)
    {
        $today = date('Y-m-d');
        $date = new \DateTime($date);
        if ($date == false) {
            // Account not registred
            return '01';
        }

        if ($date->format('Y-m-d') == $today) {
            // Account Created in this transaction
            return '02';
        }

        $newDate = new \DateTime($today . ' - 30 day');
        if ($date->format('Y-m-d') >= $newDate->format('Y-m-d')) {
            // Account created in last 30 days
            return '03';
        }

        $newDate = new \DateTime($today . ' - 60 day');
        if ($date->format('Y-m-d') >= $newDate->format('Y-m-d')) {
            // Account created from 30 to 60 days ago
            return '04';
        }

        if ($date->format('Y-m-d') < $newDate->format('Y-m-d')) {
            // Account created more then 60 days ago
            return '05';
        }
    }

    private function getChAccChangeDate($customer)
    {
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $customer->date_upd);

        if ($date) {
            return $date->format('Y-m-d');
        }
    }

    private function getDateIndicator($date)
    {
        $date = new \DateTime($date);
        $today = date('Y-m-d');
        if ($date->format('Y-m-d') == $today) {
            // Account Created in this transaction
            return '01';
        }

        $newDate = new \DateTime($today . ' - 30 day');
        if ($date->format('Y-m-d') >= $newDate->format('Y-m-d')) {
            // Account created in last 30 days
            return '02';
        }

        $newDate = new \DateTime($today . ' - 60 day');
        if ($date->format('Y-m-d') >= $newDate->format('Y-m-d')) {
            // Account created from 30 to 60 days ago
            return '03';
        }

        if ($date->format('Y-m-d') < $newDate->format('Y-m-d')) {
            // Account created more then 60 days ago
            return '04';
        }
    }

    private function getOrderInLastSixMonth()
    {
        $customer_orders = \Order::getCustomerOrders((int) $this->customer->id);
        $today = date('Y-m-d');
        $newDate = new \DateTime($today . ' - 6 month');
        $count = 0;

        foreach ($customer_orders as $customer_order) {
            if ($customer_order['date_add'] >= $newDate->format('Y-m-d')) {
                ++$count;
            }
        }

        return $count;
    }

    private function getLastUsagedestinationAddress($city, $country, $street_1, $street_2, $postcode, $state)
    {
        $customer_orders = \Order::getCustomerOrders((int) $this->customer->id);
        $date = null;
        $today = date('Y-m-d');

        foreach ($customer_orders as $customer_order) {
            $this->shippingAddress = new \Address((int) $customer_order['id_address_delivery']);

            if (
                $this->shippingAddress->city == $city
                && $this->shippingAddress->country == $country
                && $this->shippingAddress->address1 == $street_1
                && $this->shippingAddress->address2 == $street_2
                && $this->shippingAddress->postcode == $postcode
                && \State::getNameById($this->shippingAddress->id_state) == $state
            ) {
                if ($customer_order['date_add'] > $date && $customer_order['date_add'] != $today) {
                    $date = $customer_order['date_add'];
                }
            }
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        if ($date) {
            return $date->format('Y-m-d');
        }
    }

    private function getFirstUsagedestinationAddress($city, $country, $street_1, $street_2, $postcode, $state)
    {
        $customer_orders = \Order::getCustomerOrders((int) $this->customer->id);
        $date = date('Y-m-d');
        $today = date('Y-m-d');

        foreach ($customer_orders as $customer_order) {
            $this->shippingAddress = new \Address((int) $customer_order['id_address_delivery']);

            if (
                $this->shippingAddress->city == $city
                && $this->shippingAddress->country == $country
                && $this->shippingAddress->address1 == $street_1
                && $this->shippingAddress->address2 == $street_2
                && $this->shippingAddress->postcode == $postcode
                && \State::getNameById($this->shippingAddress->id_state) == $state
            ) {
                if ($customer_order['date_add'] < $date && $customer_order['date_add'] != $today) {
                    $date = $customer_order['date_add'];
                }
            }
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $date);

        if ($date) {
            return $date->format('Y-m-d');
        }
    }

    private function checkName($first_name, $last_name)
    {
        if ($first_name == $this->customer->firstname && $last_name == $this->customer->lastname) {
            return '01';
        }

        return '02';
    }
}
