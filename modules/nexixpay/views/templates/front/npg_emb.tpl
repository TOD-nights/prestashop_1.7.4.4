{**
* Copyright (c) 2020 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     7.1.0
*}

<input type="hidden" id="nexi_ajax_url" value="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'ajax')|escape:'htmlall':'UTF-8'}">

<input type="hidden" id="validation-error" value='{l s='Incorrect or missing data' mod='nexixpay'}'>
<input type="hidden" id="session-error" value='{l s='XPay Build session expired' mod='nexixpay'}'>

<form action="{$paymentLink|escape:'htmlall':'UTF-8'}" method="post" id="nexi-payment-form" style="margin-left: 2.875rem !important;">
    <p>{$description|escape:'htmlall':'UTF-8'}</p>
    <div class="nexixpay-loghi-container">
        {foreach $imageList as $image}
            <div class="img-container">
                <img src="{$image|escape:'htmlall':'UTF-8'}">
            </div>
        {/foreach}
    </div>

    <input type="hidden" id="npg-orderId" name="order_id" value="">

    <div class="loader-container">
        <p class="loading"></p>
    </div>

    <div class="build-field-row">
        <div id="CARD_NUMBER"></div>
    </div>

    <div class="build-field-row">
        <div id="EXPIRATION_DATE"></div>
        <div id="SECURITY_CODE"></div>
    </div>

    <div class="build-field-row">
        <div id="CARDHOLDER_NAME"></div>
        <div id="CARDHOLDER_SURNAME"></div>
    </div>

    <div class="build-field-row">
        <div id="CARDHOLDER_EMAIL"></div>
    </div>
    
    <div class="npg-build-error-msg-container"></div>

    <br />
</form>