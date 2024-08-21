{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     4.0.0
*}

{extends file='page.tpl'}
{block name="page_content"}
{capture name=path}{l s='Nexi XPay payment.' mod='nexixpay'}{/capture}

<h1 class="page-heading">{l s='An error occured during payment' mod='nexixpay'}</h1>


<p class="warning">{l s='The payment has been canceled.' mod='nexixpay'}

    <br /><br />
    {l s='you can try again with the payment back to your cart.' mod='nexixpay'}

</p>

<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'htmlall':'UTF-8'}" class="btn btn-primary">{l s='Return to payment methods' mod='nexixpay'}</a>

{/block}
