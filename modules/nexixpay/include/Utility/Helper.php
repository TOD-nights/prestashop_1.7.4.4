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

namespace Nexi\Utility;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Helper
{
    public static function get_link_to_module_file($relativePath)
    {
        return \Tools::getShopDomainSsl(true, true) . __PS_BASE_URI__ . 'modules/' . XPAY_MODULE_NAME . '/' . $relativePath;
    }

    public static function get_template_path($directory, $templatePath, $newTemplatePath = null)
    {
        $template = $templatePath;

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            return $template;
        }

        if ($newTemplatePath !== null) {
            $template = $newTemplatePath;
        }

        return 'module:' . XPAY_MODULE_NAME . '/views/templates/' . $directory . '/' . $template;
    }

    public static function get_front_template_path($frontPath, $frontNewTpl = null)
    {
        return static::get_template_path('front', $frontPath, $frontNewTpl);
    }

    public static function get_hook_template_path($hookPath)
    {
        return static::get_template_path('hook', $hookPath);
    }

    public static function get_template_display_path($dir, $tpl)
    {
        return 'views/templates/' . $dir . '/' . $tpl;
    }

    public static function get_hook_template_display_path($hookTpl)
    {
        return static::get_template_display_path('hook', $hookTpl);
    }

    public static function generate_random_id($length, $prefix = null)
    {
        $id = '';

        if ($prefix !== null) {
            $id .= $prefix . '-';
        }

        if ($length > 10) {
            $id .= time();
        }

        $id .= (new \DateTime())->format('uvsB');

        while (strlen($id) < $length) {
            $id .= (int) ((rand() * rand()) / rand());
        }

        return substr($id, 0, $length);
    }

    public static function getTotalFromCart($cart)
    {
        return $cart->getOrderTotal(true, \Cart::BOTH);
    }

    /**
     * @param int|float|string $m1
     * @param int|float|string $m2
     * @param int $decimals
     *
     * @return float
     */
    public static function multiply($m1, $m2, $decimals = 0)
    {
        if (class_exists('\PrestaShop\Decimal\Number')) {
            $a = new \PrestaShop\Decimal\Number((string) $m1);

            $b = new \PrestaShop\Decimal\Number((string) $m2);
        } elseif (class_exists('\PrestaShop\Decimal\DecimalNumber')) {
            $a = new \PrestaShop\Decimal\DecimalNumber((string) $m1);

            $b = new \PrestaShop\Decimal\DecimalNumber((string) $m2);
        } else {
            return round($m1 * $m2, $decimals);
        }

        $mul = new \PrestaShop\Decimal\Operation\Multiplication();

        return (float) $mul->compute($a, $b)->toPrecision($decimals);
    }

    /**
     * @param int|float|string $dividend
     * @param int|float|string $divisor
     * @param int $decimals
     *
     * @return float
     */
    public static function divide($dividend, $divisor, $decimals = 0)
    {
        if (class_exists('\PrestaShop\Decimal\Number')) {
            $a = new \PrestaShop\Decimal\Number((string) $dividend);

            $b = new \PrestaShop\Decimal\Number((string) $divisor);
        } elseif (class_exists('\PrestaShop\Decimal\DecimalNumber')) {
            $a = new \PrestaShop\Decimal\DecimalNumber((string) $dividend);

            $b = new \PrestaShop\Decimal\DecimalNumber((string) $divisor);
        } else {
            return round($dividend / $divisor, $decimals);
        }

        $div = new \PrestaShop\Decimal\Operation\Division();

        return (float) $div->compute($a, $b)->toPrecision($decimals);
    }
}
