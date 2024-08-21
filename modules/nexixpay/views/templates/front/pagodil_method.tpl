{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.0.0
*}

<form action="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'pay', [], true)|escape:'htmlall':'UTF-8'}" method="post" id='nexi-payment-form' style="margin-left: 2.875rem !important;">
    <input type="hidden" name="selectedcard" value="PAGODIL">
    <input type='hidden' id='totalAmount' value="{$totalAmount|escape:'htmlall':'UTF-8'}">
    <input type='hidden' name='installments' id='installments' value="{$defaultInstallments}">
    <input type='hidden' id='installmentLabel' value='{l s='Amount: $ installments of $€' mod='nexixpay'}'>

    <p>{l s='With PagoDIL by Cofidis, the merchant allows you to defer the payment in convenient installments without costs or interest.' mod='nexixpay'}</p>

    {if count($installments) > 1}
        <p id="pagodil-installments-number-title">{l s='Choose the number of installments' mod='nexixpay'}</p>
        <select id="pagodil-installments-number">
            {foreach $installments as $ins}
                <option value="{$ins|escape:'htmlall':'UTF-8'}" id="{$ins|escape:'htmlall':'UTF-8'}" {if $ins == $defaultInstallments}selected="selected"{/if}>{$ins|escape:'htmlall':'UTF-8'}</option>
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
</form>
