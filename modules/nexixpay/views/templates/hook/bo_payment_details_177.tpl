{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.3.0
*}

<input type="hidden" value="{$controller_xpay|escape:'htmlall':'UTF-8'}" id="controller_xpay">
<input type="hidden" value="{$controller_xpay_url|escape:'htmlall':'UTF-8'}" id="controller_xpay_url">
<input type="hidden" value="{$id_order|escape:'htmlall':'UTF-8'}" id="xpay_id_order">
<input type="hidden" value="{$paymentGateway|escape:'htmlall':'UTF-8'}" id="nexi_payment_gateway">

<div class="card mt-2">
    <div class="card-header">
        {l s='Nexi XPay payment info' mod='nexixpay'}
    </div>
    <div class="card-body nexi-payment-detail">
        {if $paymentGateway == $smarty.const.PG_XPAY}
            {include file="{$module_templates}hook/bo_xpay_details_177.tpl"}
        {elseif $paymentGateway == $smarty.const.PG_NPG}
            {include file="{$module_templates}hook/bo_npg_details_177.tpl"}
        {/if}
    </div>
</div>

<input type="hidden" id="action-question" value="{l s='Are you sure to' mod='nexixpay'}">
<input type="hidden" id="currency-label" value="{l s=$currencyLabel mod='nexixpay'}{'?'}">
<input type="hidden" id="accounting-s" value="{l s='account' mod='nexixpay'}">
<input type="hidden" id="refunding-s" value="{l s='refund' mod='nexixpay'}">
