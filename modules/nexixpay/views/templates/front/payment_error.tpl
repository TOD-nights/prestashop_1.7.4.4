{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     4.0.0
*}

{capture name=path}{l s='Nexi XPay payments.' mod='nexixpay'}{/capture}

<h1 class="page-heading">{l s='An error occured during payment' mod='nexixpay'}</h1>

<p class="warning">
    {if $error}
        {$error|escape:'htmlall':'UTF-8'}
    {/if}
</p>

<p class="cart_navigation clearfix">
    <a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'htmlall':'UTF-8'}" title="Precedente" class="button-exclusive btn btn-default">
        <i class="icon-chevron-left"></i>
        {l s='Return to payment methods' mod='nexixpay'}
    </a>
</p>
