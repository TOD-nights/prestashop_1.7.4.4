{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.0.0
*}

{capture name=path}{l s='Nexi XPay payments.' mod='nexixpay'}{/capture}

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
</head>
<form action="{$url|escape:'htmlall':'UTF-8'}" method="post" id="nexi_xpay_payment_form">
    {foreach from=$inputs key=k item=v}
        <input type="hidden" name="{$k|escape:'htmlall':'UTF-8'}" value="{$v|escape:'htmlall':'UTF-8'}" />
    {/foreach}
    <input type="submit" class="button alt" id="submit_nexi_payment_form" value="{$submit|escape:'htmlall':'UTF-8'}" />
    <a class="button" style="float:right !important;" href="{$urlBack|escape:'htmlall':'UTF-8'}">{$back}</a>
</form>
<script type="text/javascript">
    {literal}
        jQuery(document).ready(function () {
            jQuery(function () {
                jQuery("body").block({
                    message: "{/literal}{$message|escape:'htmlall':'UTF-8'}{literal}",
                    overlayCSS: {
                        background: "#fff",
                        opacity: 0.6
                    },
                    css: {
                        padding: 20,
                        textAlign: "center",
                        color: "#555",
                        border: "3px solid #aaa",
                        backgroundColor: "#fff",
                        cursor: "wait",
                        lineHeight: "32px"}
                });
                jQuery("#submit_nexi_payment_form").click();
            });
        });
    {/literal}
</script>
