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

<h1 class="page-heading">{l s='Order Summary' mod='nexixpay'}<span style="margin-bottom: 0;" class="heading-counter"><img class="methods" src="{$nexi_logo}" height="20px" hspace="5" vspace="5" style="padding-top: 5px; padding-right: 10px;">{$methods}</span></h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}


{if $nbProducts <= 0}
    <p class="warning">{l s='Your shopping cart is empty.' mod='nexixpay'}</p>
{else}
    <form action="{$link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}", 'pay', [], true)|escape:'htmlall':'UTF-8'}" method="post">

      <input type="hidden" id="selectedcard" name="selectedcard" value="{$selectedcard|escape:'htmlall':'UTF-8'}">
        <p>
            {l s='The total amount of your order is' mod='nexixpay'} <span id="amount" class="price">{$total|escape:'htmlall':'UTF-8'}</span>.
            <br/>
            {$description|escape:'htmlall':'UTF-8'}

        </p>

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
    