{**
 * Copyright (c) 2020 Nexi Payments S.p.A.
 * 
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 * @category    Payment Module
 * @package     Nexi XPay
 * @version     7.0.0
 *}

{capture name=path}{l s='Your payment method' mod='nexixpay'}{/capture}

<h1 class="page-heading" style="padding:0px !important"><span
        style="vertical-align: -webkit-baseline-middle;">{l s='Order Summary' mod='nexixpay'}</span><span
        style="margin-bottom: 0;" class="heading-counter">
        <span id="xpay_list_icon"
            style="margin-bottom:10px !important;width:auto !important;display:inline-block !important;">
            {foreach $imageList as $image}
                <span
                    style="display:inline-block !important; height:40px !important; float:left !important; {$image['style']|escape:'htmlall':'UTF-8'}">
                    <img src="{$image['url']|escape:'htmlall':'UTF-8'}"
                        style="height:100% !important;float: none !important;position: unset !important;">
                </span>
            {/foreach}
        </span>
    </span></h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts<= 0}
    <p class="warning">{l s='Your shopping cart is empty.' mod='nexixpay'}</p>
{else}

    <form action="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'pay', [], true)|escape:'htmlall':'UTF-8'}" method="post" id="nexi-payment-form">

        <div class="order_carrier_content box">
            <p class="carrier_title">
                {l s='Nexi XPay' mod='nexixpay'}
            </p>
            <p>{$description|escape:'htmlall':'UTF-8'}</p>

            <br>
            <p>
                {l s='The total amount of your order is' mod='nexixpay'} <span id="amount"
                    class="price">{$total|escape:'htmlall':'UTF-8'}</span>.
            </p>
            <br>

            {if $errCode && $msgError}
                <p style="color:red !important" ;>
                    {$msgError|escape:'htmlall':'UTF-8'} ({$errCode|escape:'htmlall':'UTF-8'})
                </p>

                <br>
            {/if}
            <input type='hidden' id='textDeleteContract'
                value='{l s='Do you want to delete this card?' mod='nexixpay'}'>

            <table class="resume table table-bordered" style='background-color:white !important;'>
                <tbody>
                    {if $oneClickEnabled}
                        {if $contracts}
                            {foreach from=$contracts key=k item=contract}
                                <tr id="tr-contract-{$contract->id_contract|escape:'htmlall':'UTF-8'}">
                                    <td class="" style='text-align:center !important; padding:15px !important; width:5% !important;'>
                                        {if $k==0 && !$errCode && !$msgError}
                                            <input type="radio" value="{$contract->num_contract|escape:'htmlall':'UTF-8'}" name="contract"
                                                class='checkbox-scelta-16 checkboxContract'>
                                        {else}
                                            <input type="radio" value="{$contract->num_contract|escape:'htmlall':'UTF-8'}" name="contract"
                                                class='checkbox-scelta-16 checkboxContract'>
                                        {/if}
                                    </td>
                                    <td style='width:90% !important;'>
                                        <strong>{$contract->brand|escape:'htmlall':'UTF-8'}</strong><br>
                                        {$contract->pan|escape:'htmlall':'UTF-8'}<br>
                                        {* {$contract->expiry_month|escape:'htmlall':'UTF-8'}/{$contract->expiry_year|escape:'htmlall':'UTF-8'} *}
                                        <br>
                                        <div style='' id='box-xpay-build-cvv-{$contract->num_contract|escape:'htmlall':'UTF-8'}'
                                            class="box-xpay-build-cvv hide">
                                            <!-- Contiene il form dei dati carta -->
                                            <div class="xpay-card-cvv"
                                                id="xpay-card-cvv-{$contract->num_contract|escape:'htmlall':'UTF-8'}"
                                                style='width:100% !important; max-width:50px !important; height:32px !important; border: 1px solid {$build.borderColorDefault|escape:'htmlall':'UTF-8'} !important; padding:6px !important; margin-bottom:10px !important;'>
                                            </div>
                                        </div>
                                    </td>
                                    <td style='width:5% !important; padding:18px !important;'>
                                        <div style='text-align:center !important;'>
                                            <input type="hidden" name="deleteLink" id="deleteLink"
                                                value="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'deletecontract')|escape:'htmlall':'UTF-8'}">
                                            <i style="cursor: pointer !important;" class='icon-trash xpay_delete_contract'
                                                data-id-contract="{$contract->id_contract|escape:'htmlall':'UTF-8'}"></i>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        {/if}
                    {/if}
                    <tr>
                        {if $contracts != null}
                            <td style='text-align:center !important; padding:15px !important; width:5% !important;'>
                                {if $errCode && $msgError}
                                    <input type="radio" value="New" name="contract" id='nuova-carta' class='checkbox-scelta-16'
                                        checked="checked">
                                {else}
                                    <input type="radio" value="New" name="contract" id='nuova-carta' class='checkbox-scelta-16'>
                                {/if}
                            </td>
                            <td colspan="2" style='width:95% !important;'>
                                <div>
                                    <strong>{l s='Use new payment card' mod='nexixpay'}</strong>
                                </div>

                                <div class='hide' id='box-xpay-build'>
                                    <!-- Contiene il form dei dati carta -->
                                    <div 
                                        id="xpay-card" 
                                        style='
                                            width:100% !important; 
                                            max-width:300px !important; 
                                            height:32px !important; 
                                            border: 1px solid {$build.borderColorDefault|escape:'htmlall':'UTF-8'} !important; 
                                            padding:6px !important; 
                                            margin-bottom:10px !important;
                                            margin-top:10px !important;
                                        '>
                                    </div>

                                    <!-- Contiene gli errori -->
                                    <div id="xpay-card-errors"
                                        style='width:100% !important; margin-bottom:10px !important; color:{$build.borderColorError|escape:'htmlall':'UTF-8'} !important;'>
                                    </div>

                                    {if $oneClickEnabled}
                                        <p class="checkbox">
                                            <input type="checkbox" name="save_token" id="save_token" value="1" />
                                            <label for="save_token">{l s='Remember card details' mod='nexixpay'}</label>
                                        </p>
                                    {/if}
                                </div>
                            {else}
                                <input type="hidden" value='New' name="contract">
                                <input type="hidden" value=1 id='nuova-carta'>
                            <td colspan="2" style='width:95% !important;'>
                                <div style="margin-bottom:10px !important;">
                                    <strong>{l s='Use new payment card' mod='nexixpay'}</strong>
                                </div>
                                <div id='box-xpay-build'>
                                    <!-- Contiene il form dei dati carta -->
                                    <div id="xpay-card"
                                        style='width:100% !important; max-width:300px !important; height:32px !important; border: 1px solid {$build.borderColorDefault|escape:'htmlall':'UTF-8'} !important; padding:6px !important; margin-bottom:10px !important;'>
                                    </div>

                                    <!-- Contiene gli errori -->
                                    <div id="xpay-card-errors"
                                        style='width:100% !important; margin-bottom:10px !important; color:{$build.borderColorError|escape:'htmlall':'UTF-8'} !important;'>
                                    </div>

                                    {if $oneClickEnabled}
                                        <p class="checkbox">
                                            <input type="checkbox" name="save_token" id="save_token" value="1" />
                                            <label for="save_token">{l s='Remember card details' mod='nexixpay'}</label>
                                        </p>
                                    {/if}
                                </div>
                            {/if}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="cart_navigation clearfix">
            <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'htmlall':'UTF-8'}" title="Precedente"
                class="button-exclusive btn btn-default">
                <i class="icon-chevron-left"></i>
                {l s='Return to payment methods' mod='nexixpay'}
            </a>
            <button type="submit" name="processPayment" class="button btn btn-default standard-checkout button-medium"
                id='pagaBtn'>
                <span>
                    {l s='Proceed to payment' mod='nexixpay'}
                    <i class="icon-chevron-right right"></i>
                </span>
            </button>
        </p>

        <!-- Parametri per costruire l'oggetto xpay build -->
        <input type='hidden' name='importo' value='{$build.importo|escape:'htmlall':'UTF-8'}' id='build-importo'>
        <input type='hidden' name='apiKey' value='{$build.apiKey|escape:'htmlall':'UTF-8'}' id='build-apiKey'>
        <input type='hidden' name='mac' value='{$build.mac|escape:'htmlall':'UTF-8'}' id='build-mac'>
        <input type='hidden' name='codiceTransazione' value='{$build.codiceTransazione|escape:'htmlall':'UTF-8'}'
            id='build-codiceTransazione'>
        <input type='hidden' name='divisa' value='{$build.divisa|escape:'htmlall':'UTF-8'}' id='build-divisa'>
        <input type='hidden' name='timeStamp' value='{$build.timeStamp|escape:'htmlall':'UTF-8'}' id='build-timeStamp'>
        <input type='hidden' name='url' value='{$build.url|escape:'htmlall':'UTF-8'}' id='build-url'>
        <input type='hidden' name='urlBack' value='{$build.urlBack|escape:'htmlall':'UTF-8'}' id='build-urlBack'>
        <input type='hidden' name='urlPost' value='{$build.urlPost|escape:'htmlall':'UTF-8'}' id='build-urlPost'>
        <input type='hidden' name='languageId' value='{$build.languageId|escape:'htmlall':'UTF-8'}' id='build-languageId'>
        <input type='hidden' value='{$build.ambiente_js|escape:'htmlall':'UTF-8'}' id='build-ambiente'>
        <input type='hidden' value='{$build.styleConfiguration|escape:'htmlall':'UTF-8'}' id="build-style-configuration">
        <input type='hidden' value='{$build.borderColorDefault|escape:'htmlall':'UTF-8'}' id='build-border-color-default'>
        <input type='hidden' value='{$build.borderColorError|escape:'htmlall':'UTF-8'}' id='build-border-color-error'>
        <input type='hidden' value='' id='codiceTransazioneSelezionato' name='codiceTransazioneSelezionato'>
        {if $oneClickEnabled != 0}
            {if isset($contracts) && is_array($contracts)}
                {foreach from=$contracts item=contract}
                    {assign var="keyMap1" value="codiceTransazione-`$contract->num_contract`"}
                    {assign var="keyMap2" value="timeStamp-`$contract->num_contract`"}
                    {assign var="keyMap3" value="mac-`$contract->num_contract`"}
                    <input type='hidden' name='codiceTransazione-{$contract->num_contract|escape:'htmlall':'UTF-8'}'
                        value='{$build.$keyMap1|escape:'htmlall':'UTF-8'}' id='build-codiceTransazione-{$contract->num_contract}'>
                    <input type='hidden' name='timeStamp-{$contract->num_contract|escape:'htmlall':'UTF-8'}'
                        value='{$build.$keyMap2|escape:'htmlall':'UTF-8'}' id='build-timeStamp-{$contract->num_contract}'>
                    <input type='hidden' name='mac-{$contract->num_contract|escape:'htmlall':'UTF-8'}'
                        value='{$build.$keyMap3|escape:'htmlall':'UTF-8'}' id='build-mac-{$contract->num_contract}'>
                {/foreach}
            {/if}
        {/if}

        <input type='hidden' value='{$nexixpaybuild_enabled3ds|escape:'htmlall':'UTF-8'}' id='nexixpaybuild_enabled3ds'>
        {if $nexixpaybuild_enabled3ds == 1}
            {foreach $par3ds as $key => $parameter}
                <input type="hidden" id='{$key|escape:'htmlall':'UTF-8'}' value='{$parameter|escape:'htmlall':'UTF-8'}'>
            {/foreach}
        {/if}


        <!-- Input valorizzati dopo la chiamata 'creaNonce' -->
        <input type='hidden' name='xpayNonce' id='xpayNonce'>
        <input type='hidden' name='xpayIdOperazione' id='xpayIdOperazione'>
        <input type='hidden' name='xpayTimeStamp' id='xpayTimeStamp'>
        <input type='hidden' name='xpayEsito' id='xpayEsito'>
        <input type='hidden' name='xpayMac' id='xpayMac'>
    </form>

    <script src="{$build.js_nexi_build|escape:'htmlall':'UTF-8'}"></script>
    <script src="/modules/{$smarty.const.XPAY_MODULE_NAME}/views/js/xpay_build.js" type="text/javascript"></script>
    <script src="/modules/{$smarty.const.XPAY_MODULE_NAME}/views/js/xpay_contract.js" type="text/javascript"></script>
{/if}