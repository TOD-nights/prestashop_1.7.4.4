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

class XPayBuildContract extends \ObjectModel
{
    public $id_contract;
    public $id_customer;
    public $num_contract;
    public $brand;
    public $pan;
    public $expiry_month;
    public $expiry_year;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'xpay_contracts',
        'primary' => 'id_contract',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT],
            'num_contract' => ['type' => self::TYPE_STRING],
            'brand' => ['type' => self::TYPE_STRING],
            'pan' => ['type' => self::TYPE_STRING],
            'expiry_month' => ['type' => self::TYPE_INT],
            'expiry_year' => ['type' => self::TYPE_INT],
        ],
    ];

    public static function createNewToken($customer_id)
    {
        return Tools::substr('OCXP_' . $customer_id . '_' . time(), 0, 30);
    }

    /**
     * Get token by id_customer
     *
     * @param int $id_customer
     * @param string $id_contract
     *
     * @return array
     */
    public static function getContracts($id_customer, $num_contract = null)
    {
        if (class_exists('PrestaShopCollection')) {
            $collection = new \PrestaShopCollection('XPayBuildContract');
        } elseif (class_exists('Collection')) {
            $collection = new \Collection('XPayBuildContract');
        }

        $collection->where('id_customer', '=', pSQL($id_customer));

        $results = $collection->getResults();

        if (is_array($results)) {
            foreach ($results as $res) {
                if ($num_contract == null || $num_contract == $res->num_contract) {
                    $contracts[] = $res;
                }
            }
        }

        if (isset($contracts) && count($contracts) < 1) {
            return false;
        }

        return $contracts;
    }

    public function deleteContract($id_customer, $id_contract)
    {
        return Db::getInstance()->delete('xpay_contracts', 'id_customer=' . $id_customer . ' AND id_contract=' . $id_contract, 1);
    }

    public function updateContract($id_contract, $month, $year)
    {
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'xpay_contracts` 
                SET expiry_month = ' . pSQL($month) . ', 
                    expiry_year = ' . pSQL($year) . ' 
                WHERE (id_contract = ' . pSQL($id_contract) . ')';

        if (Db::getInstance()->execute($sql)) {
            return true;
        }

        return false;
    }
}
