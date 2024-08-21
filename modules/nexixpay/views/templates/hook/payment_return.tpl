{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.0.0
*}

{if $status == 'ok'}
    <p>{l s='Thanks for your purchase, your order on %s is complete.' sprintf=[$shop_name] mod='nexixpay'}

        <br /><br />{l s='If you have questions, comments or concerns, please contact our' mod='nexixpay'} <a style="text-decoration:underline !important;" href="{$link->getPageLink('contact', true)|escape:'htmlall':'UTF-8'}">{l s='expert customer support team. ' mod='nexixpay'}</a>
    </p>
{else}
    <p class="warning">
        {l s='We noticed a problem with your order. If you think this is an error, feel free to contact our' mod='nexixpay'}
        <a style="text-decoration:underline !important;" href="{$link->getPageLink('contact', true)|escape:'htmlall':'UTF-8'}">{l s='expert customer support team. ' mod='nexixpay'}</a>.
    </p>
{/if}
