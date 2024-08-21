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

namespace Nexi\XPay\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Response
{
    private $apiKey;
    private $amount;
    private $currency;
    private $codTrans;
    private $sessionId;
    private $brand;
    private $firstName;
    private $lastName;
    private $mail;
    private $privateKey;
    private $mac;
    private $calculatedMac;
    private $contractNumber;
    private $result;
    private $date;
    private $time;
    private $codAut = '';   // default value if not valued
    private $pan;
    private $exp;
    private $state;
    private $nationality;
    private $message;
    private $hash;
    private $check;
    private $description;
    private $languageId;

    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCodTrans()
    {
        return $this->codTrans;
    }

    public function setCodTrans($codTrans)
    {
        $this->codTrans = $codTrans;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function setMac($mac)
    {
        $this->mac = $mac;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getCodAut()
    {
        return $this->codAut;
    }

    public function setCodAut($codAut)
    {
        $this->codAut = $codAut;
    }

    public function getPan()
    {
        return $this->pan;
    }

    public function setPan($pan)
    {
        $this->pan = $pan;
    }

    public function getExp()
    {
        return $this->exp;
    }

    public function setExp($exp)
    {
        $this->exp = $exp;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function setCheck($check)
    {
        $this->check = $check;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getLanguageId()
    {
        return $this->languageId;
    }

    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    public function calculateMac()
    {
        $toHash = 'codTrans=';

        $toHash .= $this->codTrans;
        $toHash .= 'esito=';
        $toHash .= $this->result;
        $toHash .= 'importo=';
        $toHash .= $this->amount;

        $toHash .= 'divisa=';
        $toHash .= $this->currency;

        $toHash .= 'data=';
        $toHash .= $this->date;

        $toHash .= 'orario=';
        $toHash .= $this->time;

        // if 'esito' = 'pen' codAut is not valued
        $toHash .= 'codAut=';
        $toHash .= $this->codAut;

        $toHash .= trim($this->privateKey);

        $this->calculatedMac = sha1($toHash);
    }

    public function responseVerified()
    {
        return $this->mac == $this->calculatedMac;
    }
}
