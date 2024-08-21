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

use Nexi\Utility\Logger;

if (!defined('_PS_VERSION_')) {
    exit;
}

// No namespace for compatibility with ps 1.6 object model
class OrderInfo extends \ObjectModel
{
    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'npg_payments',
        'primary' => 'id',
        'fields' => [
            'id' => ['type' => self::TYPE_INT],
            'id_cart' => ['type' => self::TYPE_INT, 'required' => true],
            'order_id' => ['type' => self::TYPE_STRING, 'required' => true],
            'security_token' => ['type' => self::TYPE_STRING, 'required' => true],
            'session_id' => ['type' => self::TYPE_STRING],
            'p_started' => ['type' => self::TYPE_BOOL],
            'order_created' => ['type' => self::TYPE_BOOL],
            'created_at' => ['type' => self::TYPE_DATE],
            'token' => ['type' => self::TYPE_STRING],
            'lock_validate' => ['type' => self::TYPE_BOOL],
        ],
    ];

    public $id;
    public $id_cart;
    public $security_token;
    public $session_id;
    public $p_started;
    public $created_at;
    public $token;

    private function getSelectQuery($where)
    {
        return '    SELECT *
                    FROM ' . _DB_PREFIX_ . 'npg_payments
                    WHERE ' . $where . '
                    ORDER BY created_at DESC';
    }

    public function getOrderByCartId($cartId)
    {
        $row = Db::getInstance()->getRow($this->getSelectQuery('id_cart = ' . pSQL($cartId)));

        if (is_array($row)) {
            return $row;
        }

        return null;
    }

    private function getByCartIdAndOrderId($cartId, $orderId)
    {
        $where = 'id_cart = ' . pSQL($cartId) . " AND order_id = '" . pSQL($orderId) . "'";

        $row = Db::getInstance()->getRow($this->getSelectQuery($where));

        if (is_array($row)) {
            return $row;
        }

        return null;
    }

    public function canReuseOrderId($cartId)
    {
        $p = $this->getOrderByCartId($cartId);

        return [$p !== null && !((bool) $p['p_started']) && !((bool) $p['order_created']), $p !== null ? $p['order_id'] : null];
    }

    public function cartIdAndOrderIdExists($cartId, $orderId)
    {
        return $this->getByCartIdAndOrderId($cartId, $orderId) !== null;
    }

    public function saveInfo($cartId, $orderId, $securityToken, $token = null, $sessionId = null)
    {
        $dati = [
            'id_cart' => $cartId,
            'order_id' => $orderId,
            'security_token' => $securityToken,
        ];

        if ($token !== null) {
            $dati['token'] = $token;
        }

        if ($sessionId !== null) {
            $dati['session_id'] = $sessionId;
        }

        return Db::getInstance()->insert('npg_payments', $dati);
    }

    public function updateExistingPaymentInfo($cartId, $orderId, $securityToken, $token = null, $sessionId = null)
    {
        $p = $this->getByCartIdAndOrderId($cartId, $orderId);

        $dati = [
            'security_token' => $securityToken,
            'token' => null,
            'session_id' => null,
        ];

        if ($token !== null) {
            $dati['token'] = $token;
        }

        if ($sessionId !== null) {
            $dati['session_id'] = $sessionId;
        }

        return Db::getInstance()->update('npg_payments', $dati, 'id = "' . pSQL($p['id']) . '"');
    }

    public function setPaymentStarted($orderId, $flag = 1)
    {
        return Db::getInstance()->update('npg_payments', ['p_started' => $flag], 'order_id = "' . pSQL($orderId) . '"');
    }

    public function setOrderCreated($orderId, $flag = 1)
    {
        return Db::getInstance()->update('npg_payments', ['order_created' => $flag], 'order_id = "' . pSQL($orderId) . '"');
    }

    public function getSecurityToken($cartId)
    {
        $ret = $this->getOrderByCartId($cartId);

        if ($ret != null) {
            return $ret['security_token'];
        }

        return null;
    }

    public function getCardToken($orderId)
    {
        $row = Db::getInstance()->getRow($this->getSelectQuery("order_id = '" . pSQL($orderId) . "'"));

        if (is_array($row)) {
            return $row['token'];
        }

        return null;
    }

    public function getSessionId($cartId, $orderId)
    {
        $row = $this->getByCartIdAndOrderId($cartId, $orderId);

        if (is_array($row)) {
            return $row['session_id'];
        }

        return null;
    }

    private function setOrderValidateLock($orderId, $lock = 1)
    {
        return Db::getInstance()->update('npg_payments', ['lock_validate' => $lock], 'order_id = "' . pSQL($orderId) . '"');
    }

    private function canTakeLock($orderId)
    {
        $where = "order_id = '" . pSQL($orderId) . "'";

        $row = Db::getInstance()->getRow($this->getSelectQuery($where));

        if (is_array($row)) {
            return $row['lock_validate'] == '0';
        }

        return null;
    }

    public function chekAndTakeLock($orderId)
    {
        $i = 0;

        do {
            ++$i;

            $lock = $this->canTakeLock($orderId);

            if ($lock === null) {
                Logger::logExceptionError(new \Exception("Order not found - orderId:" . json_encode($orderId)));
                return false;
            }

            if ($lock) {
                $this->setOrderValidateLock($orderId);
                return true;
            }

            sleep(1);
        } while ($i <= 30);

        Logger::logExceptionError(new \Exception("Reached max timeout for lock realese"));

        return false;
    }

    public function releaseLock($orderId)
    {
        return $this->setOrderValidateLock($orderId, 0);
    }
}
