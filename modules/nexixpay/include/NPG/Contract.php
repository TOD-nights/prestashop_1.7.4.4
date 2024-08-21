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
 * @version     7.0.4
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class Contract extends \ObjectModel
{
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
        'table' => 'npg_contracts',
        'primary' => 'id',
        'fields' => [
            'id' => ['type' => self::TYPE_INT],
            'id_customer' => ['type' => self::TYPE_INT],
            'num_contract' => ['type' => self::TYPE_STRING],
            'brand' => ['type' => self::TYPE_STRING],
            'pan' => ['type' => self::TYPE_STRING],
            'expiry_month' => ['type' => self::TYPE_INT],
            'expiry_year' => ['type' => self::TYPE_INT],
        ],
    ];

    public static function saveContractInfo($idCustomer, $numContratto, $brand, $pan, $scadenzaPan)
    {
        $contract = new self();

        $contract->id_customer = $idCustomer;
        $contract->num_contract = $numContratto;
        $contract->brand = $brand;
        $contract->pan = $pan;

        $oDate = DateTime::createFromFormat('Ym', $scadenzaPan);

        $contract->expiry_month = $oDate->format('m');
        $contract->expiry_year = $oDate->format('Y');

        $aContracts = self::getContracts($contract->id_customer);

        $save = true;

        if (is_array($aContracts)) {
            foreach ($aContracts as $contracts) {
                $pan = $contracts->pan;
                $expMonth = $contracts->expiry_month;
                $expYear = $contracts->expiry_year;
                $brand = $contracts->brand;

                if (
                    $pan != $contract->pan || $expMonth != $contract->expiry_month
                    || $expYear != $contract->expiry_year || $brand != $contract->brand
                ) {
                    continue;
                }

                $save = false;
                break;
            }
        }

        if ($save) {
            $contract->save();
        }
    }

    /**
     * @param int|string $customer_id
     *
     * @return void
     */
    public static function createNewToken($customer_id)
    {
        return Tools::substr(md5($customer_id . '-' . time()), 0, 18);
    }

    public function getContractById($id)
    {
        if (class_exists('PrestaShopCollection')) {
            $collection = new \PrestaShopCollection('Contract');
        } elseif (class_exists('Collection')) {
            $collection = new \Collection('Contract');
        }

        $collection->where('id', '=', pSQL($id));

        $results = $collection->getResults();

        if (is_array($results)) {
            return $results[0];
        }

        return null;
    }

    /**
     * @param int $id_customer
     * @param string $num_contract
     *
     * @return array|null array of Contract objects or null
     */
    public static function getContracts($id_customer, $num_contract = null)
    {
        if (class_exists('PrestaShopCollection')) {
            $collection = new \PrestaShopCollection('Contract');
        } elseif (class_exists('Collection')) {
            $collection = new \Collection('Contract');
        }

        $collection->where('id_customer', '=', pSQL($id_customer));

        $results = $collection->getResults();

        $contracts = [];

        if (is_array($results)) {
            foreach ($results as $res) {
                if ($num_contract == null || $num_contract == $res->num_contract) {
                    $contracts[] = $res;
                }
            }
        }

        if (isset($contracts) && count($contracts) == 0) {
            return null;
        }

        return $contracts;
    }

    public function deleteContract($id_customer, $id)
    {
        return Db::getInstance()->delete('npg_contracts', 'id_customer=' . $id_customer . ' AND id=' . $id, 1);
    }

    public function updateContract($id, $month, $year)
    {
        $sql = 'UPDATE `' . _DB_PREFIX_ . 'npg_contracts` 
                SET expiry_month = ' . pSQL($month) . ', 
                    expiry_year = ' . pSQL($year) . ' 
                WHERE (id = ' . pSQL($id) . ')';

        if (Db::getInstance()->execute($sql)) {
            return true;
        }

        return false;
    }
}
