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
 * @version     5.2.0
 */

namespace Nexi\XPay\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\CapToStateCode;
use Nexi\Redirect\Iso3166Conversion;

class Secure3d
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

    public function getParams3ds2()
    {
        $params = [];
        if ($this->customer->email != '') {
            $params['Buyer_email'] = $this->customer->email;
        }
        if ($this->shippingAddress->phone != '' && preg_match(
            '/^(\+)([0-9]{10,15})$/',
            $this->shippingAddress->phone
        )) {
            $params['Buyer_homePhone'] = $this->shippingAddress->phone;
        }
        if ($this->shippingAddress->phone_mobile != '' && preg_match(
            '/^(\+)([0-9]{10,15})$/',
            $this->shippingAddress->phone_mobile
        )) {
            $params['Buyer_workPhone'] = $this->shippingAddress->phone_mobile;
        }
        if ($this->customer->email != '') {
            $params['Buyer_account'] = $this->customer->email;
        }
        if ($this->shippingAddress->city != '') {
            $params['Dest_city'] = $this->shippingAddress->city;
        }
        if ($this->shippingAddress->country != '') {
            $params['Dest_country'] = Iso3166Conversion::getAlpha3(\Country::getIsoById(
                $this->shippingAddress->id_country
            ));
        }
        if ($this->shippingAddress->address1 != '') {
            $params['Dest_street'] = $this->shippingAddress->address1;
        }
        if ($this->shippingAddress->address2 != '') {
            $params['Dest_street2'] = $this->shippingAddress->address2;
        }
        if ($this->shippingAddress->postcode != '') {
            $params['Dest_cap'] = $this->shippingAddress->postcode;
        }
        if (CapToStateCode::getStateCode($this->shippingAddress->postcode) != null) {
            $params['Dest_stateCode'] = CapToStateCode::getStateCode(
                $this->shippingAddress->postcode
            );
        }
        if ($this->billingAddress->city != '') {
            $params['Bill_city'] = $this->billingAddress->city;
        }
        if ($this->billingAddress->country != '') {
            $params['Bill_country'] = Iso3166Conversion::getAlpha3(
                \Country::getIsoById($this->billingAddress->id_country)
            );
        }
        if ($this->billingAddress->address1 != '') {
            $params['Bill_street'] = $this->billingAddress->address1;
        }
        if ($this->billingAddress->address2 != '') {
            $params['Bill_street2'] = $this->billingAddress->address2;
        }
        if ($this->billingAddress->postcode != '') {
            $params['Bill_cap'] = $this->billingAddress->postcode;
        }
        if (CapToStateCode::getStateCode($this->billingAddress->postcode) != null) {
            $params['Bill_stateCode'] = CapToStateCode::getStateCode(
                $this->billingAddress->postcode
            );
        }

        $userParams = [];
        if ($this->getChAccDate($this->customer) != '') {
            $userParams['chAccDate'] = $this->getChAccDate($this->customer);
        }
        if ($this->getAccountDateIndicator($this->customer->date_add) != '') {
            $userParams['chAccAgeIndicator'] = $this->getAccountDateIndicator($this->customer->date_add);
        }
        if ($this->getChAccDate($this->customer) != '') {
            $userParams['chAccChangeDate'] = $this->getChAccChangeDate($this->customer);
        }
        if ($this->getDateIndicator($this->customer->date_upd) != '') {
            $userParams['chAccChangeIndicator'] = $this->getDateIndicator($this->customer->date_upd);
        }
        if ($this->getOrderInLastSixMonth() != '') {
            $userParams['nbPurchaseAccount'] = $this->getOrderInLastSixMonth();
        }
        if ($this->getLastUsagedestinationAddress(
            $this->shippingAddress->city,
            $this->shippingAddress->country,
            $this->shippingAddress->address1,
            $this->shippingAddress->address2,
            $this->shippingAddress->postcode,
            \State::getNameById($this->shippingAddress->id_state)
        ) != '') {
            $userParams['destinationAddressUsageDate'] = $this->getLastUsagedestinationAddress(
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
            $userParams['destinationAddressUsageIndicator'] = $this->getDateIndicator(
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
            $userParams['destinationNameIndicator'] = $this->checkName(
                $this->billingAddress->firstname,
                $this->billingAddress->lastname
            );
        }
        /*if ($this->getReorderItemsIndicator($this->cart) != '') {
            $userParams['reorderItemsIndicator'] = $this->getReorderItemsIndicator($this->cart);
        }*/
        if ($this->customer->is_guest == false) {
            $params = array_merge($params, $userParams);
        }

        return $params;
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

    private function getReorderItemsIndicator($order)
    {
        $customer_orders = \Order::getCustomerOrders((int) $this->customer->id);

        foreach ($order->getProducts() as $item) {
            $product_id = $item['id_product'];
            foreach ($customer_orders as $customer_order) {
                if ($customer_order['id_order'] != $order->id) {
                    $ord = new \Order($customer_order['id_order']);
                    $products = $ord->getProducts();
                    foreach ($products as $product) {
                        $old_product_id = $product['product_id'];
                        if ($old_product_id == $product_id) {
                            return '02';
                            // reorder for one product in cart
                        }
                    }
                }
            }
        }
        // First order for all product
        return '01';
    }
}
