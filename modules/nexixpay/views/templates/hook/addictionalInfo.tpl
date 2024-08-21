{**
* Copyright (c) 2019 Nexi Payments S.p.A.
*
* @author      iPlusService S.r.l.
* @copyright   Copyright (c) 2019 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
* @license     GNU General Public License v3.0
* @category    Payment Module
* @version     5.1.1
*}

{if isset($checkout) AND $checkout}
    <style>
        {literal}
            .cart-detailed-actions table.pagodil-table-block {
                margin-top: 20px;
            }
        {/literal}
    </style>
{/if}

<pagodil-sticker data-amount="{$totAmount}"
    data-installments-number="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_INS_NUMBER}"
    data-min-amount="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_MIN_CART}"
    data-max-amount="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_MAX_CART}"
    {if isset($hideLogo) AND $hideLogo}data-show-logo="false" {/if}
    data-logo-kind="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_LOGO_KIND}"
    data-info-link="{$pagoDILConfiguration.NEXIXPAY_PAGODIL_LINK}" data-logo-height="35px"
    {if isset($modeBVariant) AND $modeBVariant}data-language-mode="B" {/if} data-amount-bold="true"
    {*data-amount-change-listener-selector="#main"*}
    data-amount-selector="#main .product-prices .product-price span[itemprop='price']">
</pagodil-sticker>