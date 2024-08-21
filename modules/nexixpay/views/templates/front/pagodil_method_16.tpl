{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.0.0
*}

{capture name=path}{l s='Your payment method' mod='nexixpay'}{/capture}

<h1 class="page-heading">{$title|escape:'htmlall':'UTF-8'} <span style="margin-bottom: 0;" class="heading-counter"><img class="methods" src="{$nexi_logo}" height="20px" hspace="5" vspace="5" style="padding-top: 5px; padding-right: 10px;">{$methods}</span></h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}


{if $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.' mod='nexixpay'}</p>
{else}

    <form action="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'pay', [], true)|escape:'htmlall':'UTF-8'}" method="post">
        <input type="hidden" name="selectedcard" value="PAGODIL">
        <input type='hidden' id='totalAmount' value="{$totalAmount|escape:'htmlall':'UTF-8'}">
        <input type='hidden' name='installments' id='installments' value="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_INS_NUMBER}">
        <input type='hidden' id='installmentLabel' value='{l s='Amount: $ installments of $€' mod='nexixpay'}'>

        <p>{l s='With PagoDIL by Cofidis, the merchant allows you to defer the payment in convenient installments without costs or interest.' mod='nexixpay'}</p>

        {if count($installments) > 1}
            <p id="pagodil-installments-number-title">{l s='Choose the number of installments' mod='nexixpay'}</p>
            <select id="pagodil-installments-number">
                {foreach $installments as $ins}
                    <option value="{$ins|escape:'htmlall':'UTF-8'}" id="{$ins|escape:'htmlall':'UTF-8'}" {if $ins == $pagoDILConfiguration.NEXIXPAY_PAGODIL_INS_NUMBER}selected="selected"{/if}>{$ins|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>

            <script>
                var lastSelectedInstallments = parseInt(window.localStorage.getItem("lastSelectedInstallments"));

                var select = document.getElementById("pagodil-installments-number");

                if (lastSelectedInstallments && select.options.namedItem(lastSelectedInstallments).text) {
                    select.value = lastSelectedInstallments;
                    select.dispatchEvent(new Event("change"));

                    document.getElementById("installments").value = lastSelectedInstallments;
                }
            </script>
        {/if}

        <br><br>

        <p id="installment-text"></p>


        <p class="cart_navigation clearfix">
            <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'htmlall':'UTF-8'}" title="Precedente" class="button-exclusive btn btn-default">
                <i class="icon-chevron-left"></i>
                {l s='Other payment methods' mod='nexixpay'}
            </a>
            <button type="submit" name="processPayment" class="button btn btn-default standard-checkout button-medium" style="">
                <span>
                    {l s='Proceed to payment' mod='nexixpay'}
                    <i class="icon-chevron-right right"></i>
                </span>
            </button>
        </p>
    </form>
{/if}
<button type="submit" name="processPayment" class="button btn btn-default standard-checkout button-medium" style="">
