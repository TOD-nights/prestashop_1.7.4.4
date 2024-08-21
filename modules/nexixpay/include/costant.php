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
if (!defined('_PS_VERSION_')) {
    exit;
}

const PG_XPAY = 'XPay';
const PG_NPG = 'NPG';

const PAYMENT_S_AUTHORIZED = 'AUTHORIZED'; // Payment authorized
const PAYMENT_S_EXECUTED = 'EXECUTED'; // Payment confirmed, verification successfully executed
const PAYMENT_S_DECLINED = 'DECLINED'; // Declined by the Issuer during the authorization phase
const PAYMENT_S_DENIED_BY_RISK = 'DENIED_BY_RISK'; // Negative outcome of the transaction risk analysis
const PAYMENT_S_THREEDS_VALIDATED = 'THREEDS_VALIDATED'; // 3DS authentication OK or 3DS skipped (non-secure payment)
const PAYMENT_S_THREEDS_FAILED = 'THREEDS_FAILED'; // cancellation or authentication failure during 3DS
const PAYMENT_S_3DS_FAILED = '3DS_FAILED';
const PAYMENT_S_PENDING = 'PENDING'; // Payment ongoing. Follow up notifications are expected
const PAYMENT_S_CANCELLED = ['CANCELED', 'CANCELLED']; // Canceled by the cardholder
const PAYMENT_S_VOIDED = 'VOIDED'; // Online reversal of the full authorized amount
const PAYMENT_S_REFUNDED = 'REFUNDED'; // Full or partial amount refunded
const PAYMENT_S_FAILED = 'FAILED'; // Payment failed due to technical reasons
const PAYMENT_EXPIRED = 'EXPIRED';

const PAYMENT_SUCCESSFUL = [
    PAYMENT_S_AUTHORIZED,
    PAYMENT_S_EXECUTED,
];

const PAYMENT_FAILURE = [
    PAYMENT_S_DECLINED,
    PAYMENT_S_DENIED_BY_RISK,
    PAYMENT_S_FAILED,
    PAYMENT_S_THREEDS_FAILED,
    PAYMENT_S_3DS_FAILED,
];

const CIT = 'CIT';

const AUTHORIZATION = 'AUTHORIZATION'; // any authorization with explicit capture
const CAPTURE = 'CAPTURE'; // a captured authorization or an implicit captured payment
const VOID = 'VOID'; // reversal of an authorization
const REFUND = 'REFUND'; // refund of a captured amount
const CANCEL = 'CANCEL'; // the rollback of an capture, refund.

const NO_RECURRING = 'NO_RECURRING';
const SUBSEQUENT_PAYMENT = 'SUBSEQUENT_PAYMENT';
const CONTRACT_CREATION = 'CONTRACT_CREATION';
const CARD_SUBSTITUTION = 'CARD_SUBSTITUTION';

const SELECTED_TOKEN_NEW = 'NEW';
