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

{block name='page_title'}
    {l s='My cards' mod='nexixpay'}
{/block}

{block name='page_content'}
    <div class="order_carrier_content box">
        <input type='hidden' id='textDeleteContract'
            value='{l s='Do you want to delete this card?' mod='nexixpay'}'>
        <input type='hidden' id='textUpdateContract'
            value='{l s='Do you want to update your card details?' mod='nexixpay'}'>
        <input type="hidden" name="deleteLink" id="deleteLink"
            value="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}" , 'deletecontract'
        )|escape:'htmlall':'UTF-8'}">
        <input type="hidden" name="editLink" id="editLink"
            value="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}" , 'editcontract'
        )|escape:'htmlall':'UTF-8'}">
        <table class="resume table table-bordered" id='tabella-metodi-pagamento' style='background-color:white !important;'>
            <tbody>
                {if $oneClickEnabled == true}
                    {if isset($contracts) && is_array($contracts)}
                        {foreach from=$contracts item=contract}
                            {if $paymentGateway == $smarty.const.PG_XPAY}
                                <tr id="tr-contract-{$contract->id_contract|escape:'htmlall':'UTF-8'}">
                                    <td style='width:90% !important;padding:0.75rem !important;'>
                                        {if $contract->brand == "MasterCard"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/mastercard.png" height="30px;">
                                        {elseif $contract->brand == "VISA"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/visa.png" height="30px;">
                                        {elseif $contract->brand == "Amex"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/americanexpress.png" height="30px;">
                                        {elseif $contract->brand == "Diners"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/dinersclub.png" height="30px;">
                                        {elseif $contract->brand == "Maestro"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/maestro.png" height="30px;">
                                        {elseif $contract->brand == "PAYPAL"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/paypal.png" height="30px;">
                                        {elseif $contract->brand == "AMAZONPAY"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/amazonpay.png" height="30px;">
                                        {else}
                                            <strong>{$contract->brand|escape:'htmlall':'UTF-8'}</strong>
                                        {/if}
                                        {if $contract->brand != "PAYPAL" && $contract->brand != "AMAZONPAY"}
                                            {l s=' ends with ' mod='nexixpay'}
                                            {$contract->pan|escape:'htmlall':'UTF-8'|substr:-4}&nbsp;
                                            {if $contract->expiry_year > $smarty.now|date_format:Y or ($contract->expiry_year == $smarty.now|date_format:Y and $contract->expiry_month > $smarty.now|date_format:m)}
                                                ({l s='exp. ' mod='nexixpay'}
                                                {$contract->expiry_month|escape:'htmlall':'UTF-8'}/{$contract->expiry_year|escape:'htmlall':'UTF-8'})
                                            {else}
                                                <text style='color: red !important'>({l s='exp. ' mod='nexixpay'}
                                                    {$contract->expiry_month|escape:'htmlall':'UTF-8'}/{$contract->expiry_year|escape:'htmlall':'UTF-8'})</text>
                                            {/if}

                                            <div id='edit_card_{$contract->id_contract|escape:'htmlall':'UTF-8'}'
                                                style="display: none !important;">
                                                <label>{l s='month ' mod='nexixpay'}</label> <input type='number'
                                                    id='new_month_{$contract->id_contract|escape:'htmlall':'UTF-8'}' size='2' min='1' max='12'>
                                                <label>{l s='year ' mod='nexixpay'}</label> <input type='number'
                                                    id='new_year_{$contract->id_contract|escape:'htmlall':'UTF-8'}' size='4' min='2018'
                                                    max='2100'>
                                                <button class='save_mods' type='button'
                                                    id='save_mods_{$contract->id_contract|escape:'htmlall':'UTF-8'}'
                                                    data-id-contract="{$contract->id_contract|escape:'htmlall':'UTF-8'}">{l s='save' mod='nexixpay'}</button>
                                            </div>
                                        </td>

                                        <td style='width:5% !important; text-align:center !important; padding:15px !important;'>
                                            <i style="cursor: pointer !important;" class='icon-edit xpay_edit_contract'
                                                data-id-contract="{$contract->id_contract|escape:'htmlall':'UTF-8'}"></i>
                                        </td>
                                    {else}
                                        </td>
                                        <td></td>
                                    {/if}
                                    <td style='width:5% !important; text-align:center !important; padding:15px !important;'>
                                        <i style="cursor: pointer !important;" class='icon-bitbucket xpay_delete_contract'
                                            data-id-contract="{$contract->id_contract|escape:'htmlall':'UTF-8'}"></i>
                                    </td>
                                </tr>
                            {else}
                                <tr id="tr-contract-{$contract.id|escape:'htmlall':'UTF-8'}">
                                    <td style='width:90% !important;padding:0.75rem !important;'>
                                        {if $contract.brand == "MC"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/mastercard.png" height="30px;">
                                        {elseif $contract.brand == "VISA"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/visa.png" height="30px;">
                                        {elseif $contract.brand == "AMEX"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/americanexpress.png" height="30px;">
                                        {elseif $contract.brand == "DINERS"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/dinersclub.png" height="30px;">
                                        {elseif $contract.brand == "MAE"}
                                            <img src="{$this_path|escape:'htmlall':'UTF-8'}/views/img/maestro.png" height="30px;">
                                        {else}
                                            <strong>{$contract.brand|escape:'htmlall':'UTF-8'}</strong>
                                        {/if}
                                        {l s=' ends with ' mod='nexixpay'}
                                        {$contract.pan|escape:'htmlall':'UTF-8'|substr:-4}&nbsp;
                                        {if $contract.expiry_year > $smarty.now|date_format:Y or ($contract.expiry_year == $smarty.now|date_format:Y and $contract.expiry_month > $smarty.now|date_format:m)}
                                            ({l s='exp. ' mod='nexixpay'}
                                            {$contract.expiry_month|escape:'htmlall':'UTF-8'}/{$contract.expiry_year|escape:'htmlall':'UTF-8'})
                                        {else}
                                            <text style='color: red !important'>({l s='exp. ' mod='nexixpay'}
                                                {$contract.expiry_month|escape:'htmlall':'UTF-8'}/{$contract.expiry_year|escape:'htmlall':'UTF-8'})</text>
                                        {/if}
                                    </td>
                                    <td style='width:5% !important; text-align:center !important; padding:15px !important;'>
                                        <i style="cursor: pointer !important;" class='icon-bitbucket xpay_delete_contract'
                                            data-id-contract="{$contract.id|escape:'htmlall':'UTF-8'}"></i>
                                    </td>
                                </tr>
                            {/if}
                        {/foreach}
                    {else}
                        <p>
                            <label for="no_cards"
                                style="display:inline !important;">{l s='No registered cards' mod='nexixpay'}</label>
                        </p>
                    {/if}
                {/if}
            </tbody>
        </table>
    </div>
{/block}