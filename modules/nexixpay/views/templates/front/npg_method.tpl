{**
* Copyright (c) 2020 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.4.0
*}

<form action="{$paymentLink|escape:'htmlall':'UTF-8'}" method="post" id='nexi-payment-form'
    style="margin-left: 2.875rem !important;">
    <p>{$description|escape:'htmlall':'UTF-8'}</p>
    <div class="nexixpay-loghi-container">
        {foreach $imageList as $image}
            <div class="img-container">
                <img src="{$image|escape:'htmlall':'UTF-8'}">
            </div>
        {/foreach}
    </div>

    {if $contracts|count == 0}
        <input type="hidden" name="selected_token" value="{$smarty.const.SELECTED_TOKEN_NEW}" />
    {else}
        <table>
            <tbody>
                {foreach $contracts as $contract}
                    <tr>
                        <td>
                            <input type="radio" name="selected_token" value="{$contract.num_contract}"
                                {if $contract@iteration == 1}checked{/if} />
                        </td>
                        <td>
                            {if $contract.brand == "MC"}
                                <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/mastercard.png" height="30px;">
                            {elseif $contract.brand == "VISA"}
                                <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/visa.png" height="30px;">
                            {elseif $contract.brand == "AMEX"}
                                <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/americanexpress.png" height="30px;">
                            {elseif $contract.brand == "DINERS"}
                                <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/dinersclub.png" height="30px;">
                            {elseif $contract.brand == "MAE"}
                                <img src="{$this_path|escape:"htmlall":"UTF-8"}/views/img/maestro.png" height="30px;">
                            {else}
                                <strong>{$contract.brand|escape:"htmlall":"UTF-8"}</strong>
                            {/if}
                            {l s=' ends with ' mod='nexixpay'}{$contract.pan}
                        </td>
                    </tr>
                {/foreach}
                <tr>
                    <td>
                        <input type="radio" name="selected_token" value="{$smarty.const.SELECTED_TOKEN_NEW}" />
                    </td>
                    <td>
                        {l s='Use new payment card' mod='nexixpay'}
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
    {/if}

    {if $userLogged AND $oneClick}
        <p id="save-token-checkbox" class="checkbox" {if $contracts|count != 0}style="display: none;" {/if}>
            <input type="checkbox" name="save_token" value="1" {if $contracts|count != 0}disabled{/if} />&nbsp;
            <label for="save_token" style="display:inline !important;">
                {l s='Remember your card details securely' mod='nexixpay'}
            </label>
        </p>
    {/if}
</form>