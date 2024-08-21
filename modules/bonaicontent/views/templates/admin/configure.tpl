{*
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
*}

<prestashop-accounts></prestashop-accounts>
<div id="ps-billing"></div>
<div id="ps-modal"></div>
<div id="bonpresta-used-content"></div>

<script src="{$urlAccountsCdn|escape:'htmlall':'UTF-8'}" rel=preload></script>
<script src="{$urlBilling|escape:'htmlall':'UTF-8'}" rel=preload></script>

<script>
    /*********************
     * PrestaShop Account *
     * *******************/
    window?.psaccountsVue?.init();

    if (window.psaccountsVue.isOnboardingCompleted() != true) {
        setTimeout(() => {
            disableSettingsForm();
        }, 200);
    }


    if (window.psaccountsVue.isOnboardingCompleted() == true) {

        let planName = '';

        getShopInfo(planName);

        window.psBilling.initialize(window.psBillingContext.context, '#ps-billing', '#ps-modal', (type,
            data) => {
            // Event hook listener
            switch (type) {
                // Hook triggered when PrestaShop Billing is initialized
                case window.psBilling.EVENT_HOOK_TYPE.BILLING_INITIALIZED:
                    console.log('Billing initialized', data);
                    break;
                    // Hook triggered when the subscription is created or updated
                case window.psBilling.EVENT_HOOK_TYPE.SUBSCRIPTION_UPDATED:
                    planName = data.subscription.plan_id;
                    getShopInfo(planName);
                    disableSettingsForm();
                    console.log('Sub updated', data);
                    break;
                    // Hook triggered when the subscription is cancelled
                case window.psBilling.EVENT_HOOK_TYPE.SUBSCRIPTION_CANCELLED:
                    console.log('Sub cancelled', data);
                    getShopInfo(planName);
                    disableSettingsForm();
                    break;
            }
        });
    }

    function getShopInfo(planName) {
        $.ajax({
            url: BonAIContentAjaxUrl + '&ajax',
            type: 'POST',
            headers: {
                'cache-control': 'no-cache'
            },
            dataType: 'json',
            data: {
                action: 'shopinfo',
                plan_name: planName
            },
            success: function(response) {
                if (response['result']) {
                    let shopInfo = response['result'];
                    let usedContentForm = document.getElementById('bonpresta-used-content');
                    usedContentForm.innerHTML = shopInfo;
                } else if (response['error']) {
                    disableSettingsForm();
                    console.log(response['error']);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error executing the request');
            }
        });
    }

    function disableSettingsForm() {
        var moduleForm = document.getElementById('module_form');
        if (moduleForm && bonaicontent_hasSubscription == 0) {
            moduleForm.classList.add("disable-form");
        }
    }
</script>