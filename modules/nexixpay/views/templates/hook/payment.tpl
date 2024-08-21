{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.1.1
*}

{if $smarty.const._PS_VERSION_ >= 1.6 && $smarty.const._PS_VERSION_ < 1.7}
    <style type="text/css">
        {literal}
            img.methods {
                padding-top: 5px;
                padding-right: 10px;
            }
            p.payment_module a.nexi:after {
                display: block;
                content: "\f054";
                position: absolute;
                right: 15px;
                margin-top: -11px;
                top: 50%;
                font-family: "FontAwesome";
                font-size: 25px;
                height: 22px;
                width: 14px;
                color: #777;
            }
            p.payment_module a.nexi:hover {
                background-color: #f6f6f6;
            }

        {/literal}
    </style>
{/if}

{if $smarty.const._PS_VERSION_ >= 1.6 && $smarty.const._PS_VERSION_ < 1.7}
    {if $paymentGateway == $smarty.const.PG_XPAY}
        {if $divisa == 'EUR'}
            <p class="payment_module">
                <a class="nexi"
                    href="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'payment', ['selectedcard'=>'CC'], true)|escape:'htmlall':'UTF-8'}"
                    style="background: url({$nexi_logo|escape:'htmlall':'UTF-8'}) 15px 40px no-repeat #fbfbfb;background-size: 70px !important;padding: 33px 40px 34px 100px;background-position:10px center;">
                    {$title|escape:'htmlall':'UTF-8'} <br>
                    <span>{l s='Pay securely by credit, debit and prepaid card. Powered by Nexi.' mod='nexixpay'}</span>
                    <br>
                    {foreach from=$methods item=method}
                        {if $method->type == 'CC'}
                            {if $psVersion < 1.7}
                                <img class="methods" src="{$method->image|escape:'htmlall':'UTF-8'}" height="30px" hspace="5" vspace="5">
                            {else}
                                <img class="methods" src="{$method->image|escape:'htmlall':'UTF-8'}" height="20px" hspace="5" vspace="5">
                            {/if}
                        {/if}
                    {/foreach}
                </a>
            </p>
        {/if}
        {foreach from=$methods item=method}
            {if $method->type != 'CC'}
                <p class="payment_module">
                    <a class="nexi"
                        href="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'payment', ['selectedcard' => {$method->selectedcard|escape:'htmlall':'UTF-8'}], true)|escape:'htmlall':'UTF-8'}"
                        style="background: url({$method->image|escape:'htmlall':'UTF-8'}) 5px 5px no-repeat #fbfbfb;background-size: 70px !important;padding: 33px 40px 34px 100px;background-position:10px center;">
                        <span
                            data-module-name="{$method->selectedcard|escape:'htmlall':'UTF-8'}">{$method->description|escape:'htmlall':'UTF-8'}</span>
                        <br>
                        <span>{l s='Pay with' mod='nexixpay'} {$method->description|escape:'htmlall':'UTF-8'}
                            {l s='via Nexi XPay' mod='nexixpay'}</span>
                    </a>
                </p>
            {/if}
        {/foreach}
    {elseif $paymentGateway == $smarty.const.PG_NPG}
        <p class="payment_module">
            <a class="nexi" href="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'npgpay', [], true)|escape:'htmlall':'UTF-8'}"
                style="background: url({$nexi_logo|escape:'htmlall':'UTF-8'}) 5px 5px no-repeat #fbfbfb;background-size: 70px !important;padding: 33px 40px 34px 100px;background-position:10px center;">
                <span data-module-name="">{$description|escape:'htmlall':'UTF-8'}</span>
            </a>
        </p>
    {/if}
{/if}