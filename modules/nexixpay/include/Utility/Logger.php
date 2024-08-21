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

namespace Nexi\Utility;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Logger
{
    /**
     * Funzione di logging per le exception di tipo Warning
     *
     * @param $exception
     */
    public static function logExceptionWarning($exception)
    {
        static::logException($exception, 2);
    }

    /**
     * Funzione privata che formatta il messaggio per il logging delle eccezioni
     *
     * @param $exception
     * @param $gravity
     */
    private static function logException($exception, $gravity)
    {
        $msg = $exception->getMessage() . ' - ' . $exception->getFile() . ':' . $exception->getLine();
        static::log($msg, $gravity);
    }

    /**
     * Funzione di logging Generica
     *
     * @param $message
     * @param $gravity (1 = info, 2 = warning, 3 = error, 4 = Critical)
     */
    public static function log($message, $gravity)
    {
        \PrestaShopLogger::addLog('NEXIXPAY - ' . $message, $gravity, null, null, null, true);
    }

    /**
     * Funzione di logging per le exception di tipo Error
     *
     * @param $exception
     */
    public static function logExceptionError($exception)
    {
        static::logException($exception, 3);
    }

    /**
     * Funzione di logging per le exception di tipo Critical
     *
     * @param $exception
     */
    public static function logExceptionCritical($exception)
    {
        static::logException($exception, 4);
    }
}
