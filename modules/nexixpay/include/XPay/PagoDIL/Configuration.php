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

use Nexi\XPay\Redirect\XPay;

class Configuration
{
    private $method;
    private $module;
    private $amount;
    private $cart;
    private $numberOfInstalment;
    private $enabledCategories;

    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * pagodil saved configuration/settings
     *
     * @return type
     */
    public function getConfiguration()
    {
        $config = [];

        foreach (\NexiXPay::PAGODIL_CONFIGURATION_FIELDS as $field) {
            $config[$field] = null;

            // default values in form
            if ($field == 'NEXIXPAY_PAGODIL_LINK') {
                $config[$field] = 'https://www.pagodil.it/e-commerce/come-funziona';
            } elseif ($field == 'NEXIXPAY_PAGODIL_INS_NUMBER') {
                $config[$field] = $this->getDefaultInstallmentsValue();
            } elseif ($field == 'NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES') {
                $config[$field] = 'all';
            } elseif ($field == 'NEXIXPAY_PAGODIL_TAX_CODE_VAR') {
                $config[$field] = 'dni';
            }

            // if NEXIXPAY_PAGODIL_TAX_CODE_VAR is saved empty, default value isn't showed
            if (\Configuration::get($field) || ($field == 'NEXIXPAY_PAGODIL_TAX_CODE_VAR' && \Configuration::get($field) === '')) {
                if ($field == 'NEXIXPAY_PAGODIL_ENABLED_CATEGORIES') {
                    $config[$field] = $this->getEnabledCategories();
                } else {
                    $config[$field] = \Tools::getValue($field, \Configuration::get($field));
                }
            }
        }

        $config['NEXIXPAY_PAGODIL_MIN_CART'] = $this->getPagoDILMinAmount();

        $config['NEXIXPAY_PAGODIL_MAX_CART'] = $this->getPagoDILMaxAmount();

        return $config;
    }

    /**
     * pagodil config by nexi
     *
     * @return type
     */
    public function getPagoDILConfig()
    {
        if (!isset($this->method)) {
            $methods = XPay::getPaymentMethods();

            if (is_array($methods)) {
                foreach ($methods as $method) {
                    if ($method['code'] === 'PAGODIL') {
                        $this->method = $method;
                    }
                }
            }
        }

        return $this->method;
    }

    private function isTypeSingleInstallment($type)
    {
        return strtoupper(trim($type)) === 'VALORE';
    }

    private function isTypeRangeInstallment($type)
    {
        return strtoupper(trim($type)) === 'RANGE';
    }

    private function isTypeMultipleInstallments($type)
    {
        return strtoupper(trim($type)) === 'VALORI';
    }

    public function getArrayOfInstallmentValues($pagodilConfig = null)
    {
        if ($pagodilConfig == null) {
            $pagodilConfig = $this->getPagoDILConfig();
        }

        if ($pagodilConfig === null || count($pagodilConfig) === 0) {
            return [];
        }

        $typeInstallment = $pagodilConfig['tipoRata'];
        $installmentValues = $pagodilConfig['valoriRata'];

        if ($this->isTypeSingleInstallment($typeInstallment)) {
            return [$installmentValues];
        }

        if ($this->isTypeRangeInstallment($typeInstallment)) {
            sort($installmentValues);

            $values = [];
            for ($i = $installmentValues[0]; $i <= $installmentValues[1]; ++$i) {
                $values[] = $i;
            }

            return $values;
        }

        if ($this->isTypeMultipleInstallments($typeInstallment)) {
            sort($installmentValues);

            return $installmentValues;
        }

        return [];
    }

    public function getPagoDILMinAmount()
    {
        $pagodilConfig = $this->getPagoDILConfig();

        if (!isset($pagodilConfig['importo']['min'])) {
            return 0;
        }

        return $pagodilConfig['importo']['min'];
    }

    public function getPagoDILMaxAmount()
    {
        $pagodilConfig = $this->getPagoDILConfig();

        if (!isset($pagodilConfig['importo']['max'])) {
            return 10000000000;
        }

        return $pagodilConfig['importo']['max'];
    }

    public function getDefaultInstallmentsValue()
    {
        $installments = $this->getArrayOfInstallmentValues();

        return end($installments);
    }

    /**
     * selected categories for payment with pagodil
     *
     * @return array
     */
    public function getEnabledCategories()
    {
        if (!isset($this->enabledCategories)) {
            $categories = \Tools::getValue('NEXIXPAY_PAGODIL_ENABLED_CATEGORIES', \Configuration::get('NEXIXPAY_PAGODIL_ENABLED_CATEGORIES'));

            if ($categories) {
                if (!is_array($categories)) {
                    $categories = json_decode($categories);
                }
            } else {
                $categories = [];
            }

            $this->enabledCategories = $categories;
        }

        return $this->enabledCategories;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setNumberOfInstalments($number)
    {
        $this->numberOfInstalment = $number;
    }

    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    public function isPagoDILAvailable()
    {
        if ($this->module->active && XPay::checkNexiConfigForPagoDIL()) {
            $pagoDILConfiguration = $this->getConfiguration();

            if ($pagoDILConfiguration['NEXIXPAY_PAGODIL'] == '1') {
                return true;
            }
        }

        return false;
    }

    /**
     * remember to set amount before calling this function
     *
     * @return type
     */
    public function isAmountValid()
    {
        $ret = [
            'min' => false,
            'max' => false,
        ];

        $pagoDILConfiguration = $this->getConfiguration();

        if ($this->amount >= $pagoDILConfiguration['NEXIXPAY_PAGODIL_MIN_CART']) {
            $ret['min'] = true;
        }

        if ($this->amount <= $pagoDILConfiguration['NEXIXPAY_PAGODIL_MAX_CART']) {
            $ret['max'] = true;
        }

        $ret['res'] = $ret['min'] && $ret['max'];

        return $ret;
    }

    /**
     * remember to set numberOfInstalment before calling this function
     *
     * @return bool
     */
    public function isInstallmentValid()
    {
        if (in_array($this->numberOfInstalment, $this->getArrayOfInstallmentValues())) {
            return true;
        }

        return false;
    }

    /**
     * remember to set cart before calling this function
     *
     * @return bool
     */
    public function isProductsNumValid()
    {
        $pagoDILConfiguration = $this->getConfiguration();

        if (isset($pagoDILConfiguration['NEXIXPAY_PAGODIL_PRODUCT_LIMIT']) && $pagoDILConfiguration['NEXIXPAY_PAGODIL_PRODUCT_LIMIT'] != null) {
            $cartProducts = $this->cart->getProducts();

            if (count($cartProducts) <= $pagoDILConfiguration['NEXIXPAY_PAGODIL_PRODUCT_LIMIT']) {
                return true;
            }

            return false;
        }

        return true;
    }

    /**
     * @param array $products
     *
     * @return bool
     */
    public function checkProductsCategories($products)
    {
        $pagoDILConfiguration = $this->getConfiguration();

        if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES'] == 'selected') {
            foreach ($products as $product) {
                if (!$this->checkProductCategories($product)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param type $product
     *
     * @return bool
     */
    public function checkProductCategories($product)
    {
        $pagoDILConfiguration = $this->getConfiguration();

        if ($pagoDILConfiguration['NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES'] == 'selected') {
            $enabledCategories = $this->getEnabledCategories();

            $categories = \Product::getProductCategories($product['id_product']);

            if (count(array_intersect($categories, $enabledCategories)) == 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * remember to set cart and amount before calling this function
     *
     * @return type
     */
    public function canPayWithPagoDIL()
    {
        $ret = [
            'min' => false,
            'max' => false,
            'pNum' => false,
            'cat' => true,
        ];

        $amountRet = $this->isAmountValid();

        $ret['min'] = $amountRet['min'];
        $ret['max'] = $amountRet['max'];

        if ($this->isProductsNumValid()) {
            $ret['pNum'] = true;
        }

        $ret['cat'] = $this->checkProductsCategories($this->cart->getProducts());

        $ret['res'] = $amountRet['res'] && $ret['pNum'] && $ret['cat'];

        return $ret;
    }
}
