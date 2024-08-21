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

<form action="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", "pay", [], true)|escape:"htmlall":"UTF-8"}" method="post"
    id="nexi-payment-form" style="margin-left: 2.875rem !important">
    <span id="xpay_list_icon"
        style="margin-bottom:10px !important;width:auto !important;display:inline-block !important;">
        {foreach $imageList as $image}
            <span
                style="display:inline-block !important; height:40px !important; float:left !important; {$image["style"]|escape:"htmlall":"UTF-8"}">
                <img src="{$image["url"]|escape:"htmlall":"UTF-8"}"
                    style="height:100% !important;float: none !important;position: unset !important;">
            </span>
        {/foreach}
    </span>

    <br>

    <p>
        {l s="Pay securely by credit and debit card through Nexi." mod='nexixpay'}
    </p>

    <div class="order_carrier_content box">
        <input type="hidden" id="textDeleteContract" value="{l s="Do you want to delete this card?" mod='nexixpay'}">
        {if $oneClickEnabled && $contracts}
            <table class="resume table table-bordered" id="tabella-metodi-pagamento" style="background-color:white !important;">
                <tbody>
                    {if isset($contracts) && is_array($contracts)}
                        {foreach from=$contracts item=contract}
                            <tr id="tr-contract-{$contract->id_contract|escape:"htmlall":"UTF-8"}">
                                <td style="text-align:center !important; width:5% !important; padding: 16px .75rem !important;">
                                    <input 
                                        id="{$contract->num_contract|escape:"htmlall":"UTF-8"}" 
                                        type="radio"
                                        value="{$contract->num_contract|escape:"htmlall":"UTF-8"}"
                                        name="contract"
                                        class="checkbox-scelta-17 checkboxContract"
                                    />
                                </td>
                                <td style="width:90% !important;padding:0.75rem !important;">
                                    {if $contract->brand == "MasterCard"}
                                        <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/mastercard.png" height="30px;">
                                    {elseif $contract->brand == "VISA"}
                                        <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/visa.png" height="30px;">
                                    {elseif $contract->brand == "Amex"}
                                        <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/americanexpress.png" height="30px;">
                                    {elseif $contract->brand == "Diners"}
                                        <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/dinersclub.png" height="30px;">
                                    {elseif $contract->brand == "Maestro"}
                                        <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/maestro.png" height="30px;">
                                    {else}
                                        <strong>{$contract->brand|escape:"htmlall":"UTF-8"}</strong>
                                    {/if}
                                    {l s=" ends with " mod='nexixpay'}
                                    {$contract->pan|escape:"htmlall":"UTF-8"|substr:-4}&nbsp;
                                    <!--({$contract->expiry_month|escape:"htmlall":"UTF-8"}/{$contract->expiry_year|escape:"htmlall":"UTF-8"})--->
                                    <div style="" id="box-xpay-build-cvv-{$contract->num_contract|escape:"htmlall":"UTF-8"}"
                                        class="box-xpay-build-cvv">
                                        <!-- Contiene il form dei dati carta -->
                                        <div class="xpay-card-cvv"
                                            id="xpay-card-cvv-{$contract->num_contract|escape:"htmlall":"UTF-8"}"
                                            style="
                                                width:100% !important;
                                                max-width:50px !important;
                                                height:32px !important;
                                                border: 1px solid {$build.borderColorDefault|escape:"htmlall":"UTF-8"} !important;
                                                padding:6px !important;
                                                margin-bottom:10px !important;"
                                        ></div>

                                        <!-- Contiene gli errori -->
                                        <div 
                                            id="xpay-card-errors-cvv-{$contract->num_contract|escape:"htmlall":"UTF-8"}"
                                            style="margin-bottom:10px !important; color:{$build.borderColorError|escape:"htmlall":"UTF-8"} !important;"
                                        ></div>
                                        {if $errCode && $msgError}
                                            <p id="nexiMsgError-cvv-{$contract->num_contract|escape:"htmlall":"UTF-8"}">
                                                {$msgError|escape:"htmlall":"UTF-8"} ({$errCode|escape:"htmlall":"UTF-8"})
                                            </p>

                                            <br>
                                        {/if}
                                    </div>
                                </td>
                                <td style="width:5% !important; text-align:center !important; padding:15px !important;">
                                    <input 
                                        type="hidden" 
                                        name="deleteLink" 
                                        id="deleteLink"
                                        value="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", "deletecontract")|escape:"htmlall":"UTF-8"}"
                                    />
                                    <i 
                                        style="cursor: pointer !important;" 
                                        class="material-icons xpay_delete_contract"
                                        data-id-contract="{$contract->id_contract|escape:"htmlall":"UTF-8"}"
                                    >
                                        delete
                                    </i>
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    <tr>
                        <td style="text-align:center !important; width:5% !important; padding: 16px .75rem !important;">
                            <input type="radio" value="New" name="contract" id="nuova-carta" class="checkbox-scelta-17">
                        </td>
                        <td colspan="2" style="width:95% !important;">
                            <div style="padding: 8px 0 !important;">
                                <strong>{l s="Use new payment card" mod='nexixpay'}</strong>
                            </div>
                        {else}
                            <input type="hidden" id="nuova-carta" value="1">
                        {/if}

                        <div style="" id="box-xpay-build">
                            <!-- Contiene il form dei dati carta -->
                            <div id="xpay-card"
                                style="
                                    width:100% !important;
                                    max-width:300px !important;
                                    height:32px !important;
                                    border: 1px solid {$build.borderColorDefault|escape:"htmlall":"UTF-8"} !important;
                                    padding:6px !important;
                                    margin-bottom:10px !important;
                                    margin-top:10px !important;"
                            ></div>

                            <!-- Contiene gli errori -->
                            <div id="xpay-card-errors"
                                style="margin-bottom:10px !important; color:{$build.borderColorError|escape:"htmlall":"UTF-8"} !important;">
                            </div>
                            {if $errCode && $msgError}
                                <p id="nexiMsgError">
                                    {$msgError|escape:"htmlall":"UTF-8"} ({$errCode|escape:"htmlall":"UTF-8"})
                                </p>

                                <br>
                            {/if}
                            {if $oneClickEnabled}
                                <p class="checkbox">
                                    <input type="checkbox" name="save_token" id="save_token" value="1" />&nbsp;
                                    <label for="save_token" style="display:inline !important;">
                                        {l s="Remember your card details securely" mod='nexixpay'}
                                    </label>
                                </p>
                            {/if}
                        </div>
                        {if $oneClickEnabled &&  $contracts}
                        </td>
                    </tr>
                </tbody>
            </table>
        {/if}
        <br>
    </div>

    <input type="hidden" name="importo" value="{$build.importo|escape:"htmlall":"UTF-8"}" id="build-importo">
    <input type="hidden" name="apiKey" value="{$build.apiKey|escape:"htmlall":"UTF-8"}" id="build-apiKey">
    <input type="hidden" name="mac" value="{$build.mac|escape:"htmlall":"UTF-8"}" id="build-mac">
    <input type="hidden" name="codiceTransazione" value="{$build.codiceTransazione|escape:"htmlall":"UTF-8"}" id="build-codiceTransazione">
    <input type="hidden" name="divisa" value="{$build.divisa|escape:"htmlall":"UTF-8"}" id="build-divisa">
    <input type="hidden" name="timeStamp" value="{$build.timeStamp|escape:"htmlall":"UTF-8"}" id="build-timeStamp">
    <input type="hidden" name="url" value="{$build.url|escape:"htmlall":"UTF-8"}" id="build-url">
    <input type="hidden" name="urlBack" value="{$build.urlBack|escape:"htmlall":"UTF-8"}" id="build-urlBack">
    <input type="hidden" name="urlPost" value="{$build.urlPost|escape:"htmlall":"UTF-8"}" id="build-urlPost">
    <input type="hidden" name="languageId" value="{$build.languageId|escape:"htmlall":"UTF-8"}" id="build-languageId">
    <input type="hidden" value="{$build.ambiente_js|escape:"htmlall":"UTF-8"}" id="build-ambiente">
    <input type="hidden" value="{$build.styleConfiguration|escape:"htmlall":"UTF-8"}" id="build-style-configuration">
    <input type="hidden" value="{$build.borderColorDefault|escape:"htmlall":"UTF-8"}" id="build-border-color-default">
    <input type="hidden" value="{$build.borderColorError|escape:"htmlall":"UTF-8"}" id="build-border-color-error">
    <input type="hidden" value="" id="codiceTransazioneSelezionato" name="codiceTransazioneSelezionato">
    {if $oneClickEnabled}
        {if isset($contracts) && is_array($contracts) && is_array($contracts)}
            {foreach from=$contracts item=contract}
                {assign var="keyMap1" value="codiceTransazione-`$contract->num_contract`"}
                {assign var="keyMap2" value="timeStamp-`$contract->num_contract`"}
                {assign var="keyMap3" value="mac-`$contract->num_contract`"}
                <input type="hidden" name="codiceTransazione-{$contract->num_contract|escape:"htmlall":"UTF-8"}" value="{$build.$keyMap1|escape:"htmlall":"UTF-8"}" id="build-codiceTransazione-{$contract->num_contract}">
                <input type="hidden" name="timeStamp-{$contract->num_contract|escape:"htmlall":"UTF-8"}" value="{$build.$keyMap2|escape:"htmlall":"UTF-8"}" id="build-timeStamp-{$contract->num_contract}">
                <input type="hidden" name="mac-{$contract->num_contract|escape:"htmlall":"UTF-8"}" value="{$build.$keyMap3|escape:"htmlall":"UTF-8"}" id="build-mac-{$contract->num_contract}">
            {/foreach}
        {/if}
    {/if}

    <input type="hidden" value="{$nexixpaybuild_enabled3ds|escape:"htmlall":"UTF-8"}" id="nexixpaybuild_enabled3ds">
    {if $nexixpaybuild_enabled3ds == 1}
        {foreach $par3ds as $key => $parameter}
            <input type="hidden" id="{$key|escape:"htmlall":"UTF-8"}" value="{$parameter|escape:"htmlall":"UTF-8"}">
        {/foreach}
    {/if}

    <!-- input valorizzati dopo la chiamata "creaNonce" -->
    <input type="hidden" name="xpayNonce" id="xpayNonce">
    <input type="hidden" name="xpayIdOperazione" id="xpayIdOperazione">
    <input type="hidden" name="xpayTimeStamp" id="xpayTimeStamp">
    <input type="hidden" name="xpayEsito" id="xpayEsito">
    <input type="hidden" name="xpayMac" id="xpayMac">
</form>

<script src="{$build.js_nexi_build|escape:"htmlall":"UTF-8"}"></script>