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

namespace Nexi\Utility;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\CurrencyNotSupported;

class CurrencyHelper
{
    /**
     * @param int|string|null $idCurrency
     * @param int|string|null $iso
     *
     * @return string
     */
    public static function getCurrencyISOCode($idCurrency = null, $iso = null)
    {
        if ($idCurrency !== null) {
            $currency = new \Currency((int) $idCurrency);
        }

        if ($iso !== null) {
            $currency = static::getCurrencyByIsoCode($iso);
        }

        return $currency->iso_code;
    }

    /**
     * @param int|string $idCurrency
     *
     * @return int
     */
    public static function getCurrencyNumericIsoCode($idCurrency)
    {
        $currency = new \Currency((int) $idCurrency);

        if (isset($currency->numeric_iso_code)) {
            $currencyCode = $currency->numeric_iso_code;
        } else {
            $currencyCode = $currency->iso_code_num;
        }

        return (int) $currencyCode;
    }

    /**
     * @param int|string $currency iso code
     *
     * @return \Currency
     *
     * @throws CurrencyNotSupported
     */
    public static function getCurrencyByIsoCode($currency)
    {
        if (is_numeric($currency)) {
            $idCurrency = \Currency::getIdByNumericIsoCode((int) $currency);
        } else {
            $idCurrency = \Currency::getIdByIsoCode($currency);
        }

        if ($idCurrency === 0) {
            throw new CurrencyNotSupported($currency);
        }

        return new \Currency($idCurrency);
    }

    /**
     * @param string $currency iso code
     *
     * @return string
     */
    public static function getCurrencySign($currency)
    {
        try {
            $c = static::getCurrencyByIsoCode($currency);
        } catch (CurrencyNotSupported $exc) {
            Logger::logExceptionError($exc);

            return $currency;
        }

        return $c->getSign();
    }

    /**
     * returns the multiplier to convert the amount to currency min unit
     *
     * @param string $currency
     *
     * @return int
     *
     * @throws CurrencyNotSupported
     */
    private static function getCurrencyMinUnitMultiplier($currencyList, $currency)
    {
        $currency = static::getCurrencyISOCode(null, $currency);

        if (!array_key_exists($currency, $currencyList)) {
            $exc = new CurrencyNotSupported($currency);

            Logger::logExceptionError($exc);

            throw $exc;
        }

        $decimals = $currencyList[$currency];

        $mul = pow(10, $decimals);

        if ($mul === false) {
            $exc = new \Exception('Error calculating min unit multiplier, currency: ' . $currency . ' - decimals: ' . $decimals);

            Logger::logExceptionError($exc);

            throw $exc;
        }

        return $mul;
    }

    /**
     * returns the amount ronded to the number of decimals of the given currency
     *
     * @param array $currencyList
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return float
     */
    private static function getRoundedAmount($currencyList, $amount, $currency)
    {
        $currency = static::getCurrencyISOCode(null, $currency);

        return \Tools::ps_round($amount, $currencyList[$currency]);
    }

    /**
     * converts the amount to the minumum currency unit
     *
     * @param array $currencyList
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return int
     */
    private static function calculateAmountToMinUnit($currencyList, $amount, $currency)
    {
        $currency = static::getCurrencyISOCode(null, $currency);

        $mul = static::getCurrencyMinUnitMultiplier($currencyList, $currency);

        return (int) Helper::multiply(
            static::getRoundedAmount($currencyList, $amount, $currency),
            $mul
        );
    }

    /**
     * from minimum unit value to 'normal' formatted amount
     *
     * @param array $currencyList
     * @param int|float|string $amount to minimum unit
     * @param string $currency
     *
     * @return float
     */
    private static function fromMinUnitToAmount($currencyList, $amount, $currency)
    {
        $currency = static::getCurrencyISOCode(null, $currency);

        return Helper::divide(
            $amount,
            static::getCurrencyMinUnitMultiplier($currencyList, $currency),
            $currencyList[$currency]
        );
    }

    /**
     * formats amount to be displayed
     *
     * @param array $currencyList
     * @param string $amount to minimum unit
     * @param string $currency
     * @param string $decimalSep
     * @param string $thousandsSep
     *
     * @return string
     */
    private static function formatAmount($currencyList, $amount, $currency, $decimalSep = ',', $thousandsSep = '.')
    {
        $currency = static::getCurrencyISOCode(null, $currency);

        return number_format(
            static::fromMinUnitToAmount(
                $currencyList,
                $amount,
                $currency
            ),
            $currencyList[$currency],
            $decimalSep,
            $thousandsSep
        );
    }

    // XPAY

    /**
     * XPay - currency map to the number of digits after the decimal separator
     *
     * @var array
     */
    private static $xpayCurrenciesList = [
        'EUR' => 2,
        'CZK' => 2,
        'PLN' => 2,
        'NZD' => 2,
        'AUD' => 2,
    ];

    /**
     * returns list of supported currencies
     *
     * @return array
     */
    public static function getXPaySupportedCurrencyList()
    {
        return array_keys(static::$xpayCurrenciesList);
    }

    /**
     * returns the amount ronded to the number of decimals of the given currency
     *
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return float
     */
    public static function getRoundedAmountXPay($amount, $currency)
    {
        return static::getRoundedAmount(
            static::$xpayCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * converts the amount to the minumum currency unit
     *
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return int
     */
    public static function calculateAmountToMinUnitXPay($amount, $currency)
    {
        return static::calculateAmountToMinUnit(
            static::$xpayCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * from minimum unit value to 'normal' formatted amount
     *
     * @param int|float|string $amount to minimum unit
     * @param string $currency
     *
     * @return float
     */
    public static function fromMinUnitToAmountXPay($amount, $currency)
    {
        return static::fromMinUnitToAmount(
            static::$xpayCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * formats amount to be displayed
     *
     * @param string $amount to minimum unit
     * @param string $currency
     * @param string $decimalSep
     * @param string $thousandsSep
     *
     * @return string
     */
    public static function formatAmountXPay($amount, $currency, $decimalSep = ',', $thousandsSep = '.')
    {
        return static::formatAmount(
            static::$xpayCurrenciesList,
            $amount,
            $currency,
            $decimalSep,
            $thousandsSep
        );
    }

    // NPG

    /**
     * NPG - currency map to the number of digits after the decimal separator
     *
     * @var array
     */
    private static $npgCurrenciesList = [
        'AED' => 2,
        'AOA' => 2,
        'ARS' => 2,
        'AUD' => 2,
        'AZN' => 2,
        'BAM' => 2,
        'BGN' => 2,
        'BHD' => 3,
        'BRL' => 2,
        'BYN' => 2,
        'BYR' => 0,
        'CAD' => 2,
        'CHF' => 2,
        'CLP' => 0,
        'CNY' => 2,
        'COP' => 2,
        'CZK' => 2,
        'DKK' => 2,
        'EGP' => 2,
        'EUR' => 2,
        'GBP' => 2,
        'GIP' => 2,
        'HKD' => 2,
        'HRK' => 2,
        'HUF' => 2,
        'INR' => 2,
        'ISK' => 0,
        'JOD' => 3,
        'JPY' => 0,
        'KRW' => 0,
        'KWD' => 3,
        'KZT' => 2,
        'LTL' => 2,
        'LVL' => 2,
        'MKD' => 2,
        'MXN' => 2,
        'MYR' => 2,
        'NGN' => 2,
        'NOK' => 2,
        'PHP' => 2,
        'PLN' => 2,
        'QAR' => 2,
        'RON' => 2,
        'RSD' => 2,
        'RUB' => 2,
        'SAR' => 2,
        'SEK' => 2,
        'SGD' => 2,
        'THB' => 2,
        'TRY' => 2,
        'TWD' => 2,
        'UAH' => 2,
        'USD' => 2,
        'VEF' => 2,
        'VND' => 0,
        'ZAR' => 2,
    ];

    /**
     * returns list of supported currencies
     *
     * @return array
     */
    public static function getNpgSupportedCurrencyList()
    {
        return array_keys(static::$npgCurrenciesList);
    }

    /**
     * returns the amount ronded to the number of decimals of the given currency
     *
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return float
     */
    public static function getRoundedAmountNPG($amount, $currency)
    {
        return static::getRoundedAmount(
            static::$npgCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * converts the amount to the minumum currency unit
     *
     * @param int|float|string $amount
     * @param string $currency
     *
     * @return int
     */
    public static function calculateAmountToMinUnitNPG($amount, $currency)
    {
        return static::calculateAmountToMinUnit(
            static::$npgCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * from minimum unit value to 'normal' formatted amount
     *
     * @param int|float|string $amount to minimum unit
     * @param string $currency
     *
     * @return float
     */
    public static function fromMinUnitToAmountNPG($amount, $currency)
    {
        return static::fromMinUnitToAmount(
            static::$npgCurrenciesList,
            $amount,
            $currency
        );
    }

    /**
     * formats amount to be displayed
     *
     * @param string $amount to minimum unit
     * @param string $currency
     * @param string $decimalSep
     * @param string $thousandsSep
     *
     * @return string
     */
    public static function formatAmountNPG($amount, $currency, $decimalSep = ',', $thousandsSep = '.')
    {
        return static::formatAmount(
            static::$npgCurrenciesList,
            $amount,
            $currency,
            $decimalSep,
            $thousandsSep
        );
    }
}
