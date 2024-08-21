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

use Nexi\Utility\CurrencyHelper;

if (!defined('_PS_VERSION_')) {
    exit;
}

// No namespace for compatibility with ps 1.6 object model
class PaymentInfo extends \ObjectModel
{
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'xpay_payments_info',
        'primary' => 'codTrans',
        'fields' => [
            'codTrans' => ['type' => self::TYPE_STRING],
            'idCart' => ['type' => self::TYPE_STRING],
            'amount' => ['type' => self::TYPE_STRING],
            'currency' => ['type' => self::TYPE_STRING],
            'brand' => ['type' => self::TYPE_STRING],
            'result' => ['type' => self::TYPE_STRING],
            'date' => ['type' => self::TYPE_STRING],
            'autCode' => ['type' => self::TYPE_STRING],
            'pan' => ['type' => self::TYPE_STRING],
            'exp' => ['type' => self::TYPE_STRING],
            'nationality' => ['type' => self::TYPE_STRING],
            'firstName' => ['type' => self::TYPE_STRING],
            'lastName' => ['type' => self::TYPE_STRING],
            'mail' => ['type' => self::TYPE_STRING],
            'message' => ['type' => self::TYPE_STRING],
            'contractNumber' => ['type' => self::TYPE_STRING],
            'moduleVariant' => ['type' => self::TYPE_STRING],
        ],
    ];

    public $codTrans;
    public $idCart;
    public $amount;
    public $currency;
    public $brand;
    public $result;
    public $date;
    public $autCode;
    public $pan;
    public $exp;
    public $nationality;
    public $firstName;
    public $lastName;
    public $mail;
    public $message;
    public $contractNumber;
    public $moduleVariant;

    private static function getModuleVariant()
    {
        if (NexiXPay::isXPayBuild()) {
            return 'build';
        }

        return 'redirect';
    }

    public function save($nullValues = false, $autodate = true)
    {
        $this->moduleVariant = self::getModuleVariant();

        parent::save($nullValues, $autodate);
    }

    public static function getInfo($cartId)
    {
        $ret = [];

        if (class_exists('PrestaShopCollection')) {
            $collection = new \PrestaShopCollection('\PaymentInfo');
        } elseif (class_exists('Collection')) {
            $collection = new \Collection('\PaymentInfo');
        }

        $collection->where('idCart', '=', pSQL($cartId));
        $collection->orderBy('date', 'desc');

        $results = $collection->getResults();

        if (isset($results[0])) {
            foreach ($results[0] as $key => $value) {
                $ret[$key] = $value;
            }
        }

        if ((isset($ret['firstName']) && $ret['firstName'] != '')
            && (isset($ret['lastName']) && $ret['lastName'] != '')
        ) {
            $ret['_customer'] = $ret['firstName'] . ' ' . $ret['lastName'];
        }
        $ret['_exp'] = '';
        $ret['_date'] = '';

        if (isset($ret['exp']) && $ret['exp'] != '') {
            $date = \DateTime::createFromFormat('Ym', $ret['exp']);
            $ret['_exp'] = $date->format('m/Y');
        }

        if (isset($ret['date']) && $ret['date'] != '') {
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $ret['date']);
            $ret['_date'] = $date->format('d/m/Y H:i:s');
        }

        if (isset($ret['amount'])) {
            $ret['_amount'] = CurrencyHelper::formatAmountXPay(
                CurrencyHelper::calculateAmountToMinUnitXPay($ret['amount'], $ret['currency']),
                $ret['currency']
            );
        }

        return $ret;
    }
}
