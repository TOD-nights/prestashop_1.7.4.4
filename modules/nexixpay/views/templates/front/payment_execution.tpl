{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.0.0
*}

<form action="{Context::getContext()->link->getModuleLink("{$smarty.const.XPAY_MODULE_NAME}" , 'pay' , [], true)|escape:'htmlall':'UTF-8'}" method="post" id='nexi-payment-form' style="margin-left: 2.875rem !important">
    <span id="xpay_list_icon"
        style="margin-bottom:10px !important; width:auto !important; display:inline-block !important;">
        {if isset($imageList)}
            {foreach $imageList as $image}
                <span
                    style="display:inline-block !important; height:40px !important; float:left !important; {$image['style']|escape:'htmlall':'UTF-8'}">
                    <img src="{$image['url']|escape:'htmlall':'UTF-8'}"
                        style="height:100% !important; float: none !important; position: unset !important;">
                </span>
            {/foreach}
        {/if}
    </span>
    
    <br>

    <p>
        {l s='Pay securely by credit, debit and prepaid card. Powered by Nexi.' mod='nexixpay'}
    </p>

    <input type="hidden" id="selectedcard" name="selectedcard" value="CC">
</form>