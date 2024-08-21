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

<div class="result_wrapper">
    {if isset($result) && $result}
        {foreach from=$result item=resultItem}
            <div class="wrap_item">
                <textarea id="bonai_result"
                    class="form-control mb-3">{$resultItem|replace:'"':''|escape:'html':'UTF-8'}</textarea>
                <span class="btn btn-primary" id="approve-results"
                    data-content_type="{$content_type}">{l s='Approve' mod='bonaicontent'}</span>
                <span
                    class="btn-outline-secondary ml-3 btn  copy-results">{l s='Copy' mod='bonaicontent'}</span>
                <span class="btn btn-outline-secondary ml-3" id="clear-results"
                    data-content_type="{$content_type}">{l s='Clear' mod='bonaicontent'}</span>
            </div>
        {/foreach}
    {else}
        <h6>{l s='No result' mod='bonaicontent'}</h6>
    {/if}
</div>