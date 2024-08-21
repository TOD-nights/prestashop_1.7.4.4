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

{if isset($result) && $result}
    <div class="defaultForm form-horizontal">
        <div class="panel">
            <div class="panel-heading">{l s='Word Usage Stats' mod='bonaicontent'}</div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Product name' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['product_title_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['product_title_words']|escape:'htmlall':'UTF-8'}
                        </p>
                        <h4></h4>
                    </div>
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Product summery' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['product_summary_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['product_summary_words']|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Product description' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['product_description_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['product_description_words']|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Product meta content' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['product_seo_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['product_seo_words']|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Category description' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['category_description_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['category_description_words']|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                    <div class="col-6 col-xs-6 col-md-3 col-lg-2 text-center">
                        <h4>{l s='Product marketplace description' mod='bonaicontent'}</h4>
                        <p>
                            {$result['usage_data']['product_marketplace_words']|escape:'htmlall':'UTF-8'} /
                            {$result['plan']['product_marketplace_words']|escape:'htmlall':'UTF-8'}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}