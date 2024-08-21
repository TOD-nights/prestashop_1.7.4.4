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

namespace Nexi\XPay\Build\Payload\Request;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\XPay\Redirect\Payload\Request\Request;

class RequestNonce extends Request
{
    private $codiceTransazione;
    private $importo;
    private $divisa;
    private $xpayNonce;
    private $TCONTAB;
    private $nome;
    private $cognome;
    private $mail;

    public function __construct($apiKey, $privateKey, $codiceTransazione, $importo, $divisa, $xpayNonce, $TCONTAB, $nome = null, $cognome = null, $mail = null)
    {
        parent::__construct($apiKey, $privateKey);

        $this->codiceTransazione = $codiceTransazione;
        $this->importo = $importo;
        $this->divisa = $divisa;
        $this->xpayNonce = $xpayNonce;
        $this->TCONTAB = $TCONTAB;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->mail = $mail;
    }

    public function getPayload()
    {
        $payLoad = parent::getPayload();
        unset($payLoad['mac']);

        $mod = \Module::getInstanceByName(XPAY_MODULE_NAME);

        $payLoad = array_merge($payLoad, [
            'codiceTransazione' => $this->codiceTransazione,
            'importo' => (int) (string) $this->importo,
            'divisa' => (int) $this->divisa,
            'xpayNonce' => $this->xpayNonce,
            'mac' => $this->generateMac(),
            'parametriAggiuntivi' => [
                'TCONTAB' => $this->TCONTAB,
                'Note1' => 'prestashop',
                'Note2' => \Tools::substr(_PS_VERSION_, 0, 3) . '.x',
                'Note3' => $mod->version . '-build',
            ],
        ]);

        if ($this->nome !== null) {
            $payLoad['parametriAggiuntivi']['nome'] = $this->nome;
        }

        if ($this->cognome !== null) {
            $payLoad['parametriAggiuntivi']['cognome'] = $this->cognome;
        }

        if ($this->mail !== null) {
            $payLoad['parametriAggiuntivi']['mail'] = $this->mail;
        }

        return $payLoad;
    }

    private function generateMac()
    {
        return sha1('apiKey=' . $this->apiKey
            . 'codiceTransazione=' . $this->codiceTransazione
            . 'importo=' . $this->importo
            . 'divisa=' . $this->divisa
            . 'xpayNonce=' . $this->xpayNonce
            . 'timeStamp=' . $this->timestamp . $this->privateKey);
    }
}
