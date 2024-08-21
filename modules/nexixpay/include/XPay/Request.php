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

use Nexi\Redirect\Error\RedirectRequest;

class Request
{
    private $urlRequest;
    private $apiKey;
    private $amount;
    private $curency = 'EUR';
    private $codTrans;
    private $url;
    private $urlBack;
    private $privateKey;
    private $mac;
    private $mail;
    private $languageId;
    private $urlPost;
    private $description;
    private $firstName;
    private $lastName;
    private $sessionId;
    private $contractNumber;
    private $serviceType;
    private $requestType;
    private $contabType;
    private $Note1;
    private $Note2;
    private $Note3;

    private $urlRedirect;

    public function __construct($urlRequest)
    {
        $this->urlRequest = $urlRequest;
        $this->Note1 = 'prestashop';
        $this->Note2 = \Tools::substr(_PS_VERSION_, 0, 3) . '.x';
        $mod = \Module::getInstanceByName(XPAY_MODULE_NAME);
        $this->Note3 = $mod->version;
    }

    public function setApiKey($alias)
    {
        $this->apiKey = $alias;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setCodTrans($codTrans)
    {
        $this->codTrans = $codTrans;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setUrlBack($urlBack)
    {
        $this->urlBack = $urlBack;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getLanguageId()
    {
        return $this->languageId;
    }

    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    public function setUrlPost($urlPost)
    {
        $this->urlPost = $urlPost;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function setContractNumber($customerId)
    {
        $this->contractNumber = \Tools::substr($customerId . '_' . time(), 0, 30);
    }

    public function setService($serviceType)
    {
        $this->serviceType = $serviceType;
    }

    public function setAccounting($contabType)
    {
        $this->contabType = $contabType;
    }

    public function calculateUrlRedirect()
    {
        $this->urlRedirect = $this->urlRequest;

        $this->urlRedirect .= '?';

        if ($this->apiKey != null && !empty($this->apiKey)) {
            $this->urlRedirect .= 'alias=' . trim($this->apiKey);
        } else {
            throw new RedirectRequest('Alias required');
        }

        if ($this->amount != null) {
            $this->urlRedirect .= '&importo=' . $this->amount;
        } else {
            throw new RedirectRequest('amount required');
        }

        if ($this->curency != null) {
            $this->urlRedirect .= '&divisa=' . $this->curency;
        } else {
            throw new RedirectRequest('currency required');
        }

        if ($this->codTrans != null && !empty($this->codTrans)) {
            $this->urlRedirect .= '&codTrans=' . $this->codTrans;
        } else {
            throw new RedirectRequest('codTrans required');
        }

        if ($this->url != null && !empty($this->url)) {
            $this->urlRedirect .= '&url=' . $this->url;
        } else {
            throw new RedirectRequest('url required');
        }

        if ($this->urlBack != null && !empty($this->urlBack)) {
            $this->urlRedirect .= '&url_back=' . $this->urlBack;
        } else {
            throw new RedirectRequest('urlBack required');
        }

        if ($this->languageId != null && !empty($this->languageId)) {
            $this->urlRedirect .= '&languageId=' . $this->languageId;
        }

        if ($this->urlPost != null && !empty($this->urlPost)) {
            $this->urlRedirect .= '&urlpost=' . $this->urlPost;
        }

        if ($this->description != null && !empty($this->description)) {
            $this->urlRedirect .= '&descrizione=' . $this->description;
        }

        if ($this->firstName != null && !empty($this->firstName)) {
            $this->urlRedirect .= '&nome=' . $this->firstName;
        }

        if ($this->lastName != null && !empty($this->lastName)) {
            $this->urlRedirect .= '&cognome=' . $this->lastName;
        }

        if ($this->sessionId != null && !empty($this->sessionId)) {
            $this->urlRedirect .= '&session_id=' . $this->sessionId;
        }

        if ($this->mail != null && !empty($this->mail)) {
            $this->urlRedirect .= '&mail=' . $this->mail;
        }

        if ($this->contractNumber != null && !empty($this->contractNumber)) {
            $this->urlRedirect .= '&num_contratto=' . $this->contractNumber;
        }

        if ($this->serviceType != null && !empty($this->serviceType)) {
            $this->urlRedirect .= '&tipo_servizio=' . $this->serviceType;
        }

        if ($this->requestType != null && !empty($this->requestType)) {
            $this->urlRedirect .= '&tipo_richiesta=' . $this->requestType;
        }

        if ($this->contabType != null && !empty($this->contabType)) {
            $this->urlRedirect .= '&TCONTAB=' . $this->contabType;
        }

        if ($this->Note1 != null && !empty($this->Note1)) {
            $this->urlRedirect .= '&Note1=' . $this->Note1;
        }

        if ($this->Note2 != null && !empty($this->Note2)) {
            $this->urlRedirect .= '&Note2=' . $this->Note2;
        }

        if ($this->Note3 != null && !empty($this->Note3)) {
            $this->urlRedirect .= '&Note3=' . $this->Note3;
        }

        $this->urlRedirect .= '&mac=' . $this->calculatedMac();
    }

    private function calculatedMac()
    {
        return sha1('codTrans=' . $this->codTrans
            . 'divisa=' . $this->curency . 'importo='
            . $this->amount . trim($this->privateKey));
    }
}
