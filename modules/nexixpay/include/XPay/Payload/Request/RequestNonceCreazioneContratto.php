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

class RequestNonceCreazioneContratto extends RequestNonce
{
    private $numeroContratto;

    public function __construct($apiKey, $privateKey, $codiceTransazione, $importo, $divisa, $xpayNonce, $numeroContratto, $TCONTAB, $nome = null, $cognome = null, $mail = null)
    {
        parent::__construct($apiKey, $privateKey, $codiceTransazione, $importo, $divisa, $xpayNonce, $TCONTAB, $nome, $cognome, $mail);

        $this->numeroContratto = $numeroContratto;
    }

    public function getPayload()
    {
        $payLoad = parent::getPayload();

        $payLoad['numeroContratto'] = $this->numeroContratto;

        return $payLoad;
    }
}
