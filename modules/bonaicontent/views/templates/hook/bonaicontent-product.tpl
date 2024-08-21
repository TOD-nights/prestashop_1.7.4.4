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

<h2>
    {l s='Generate title, summary or description' mod='bonaicontent'}
</h2>
<div class="row">
    <div class="bonaicontent-form-inner col-12 col-xs-12 mb-3">
        <select id="bonaicontent_content_type" class="custom-select mb-3">
            <option value="productTitle" selected="selected">{l s='Title' mod='bonaicontent'}</option>
            <option value="productSummary">{l s='Summary' mod='bonaicontent'}</option>
            <option value="productDescription">{l s='Description' mod='bonaicontent'}</option>
            <option value="marketplaceDescription">{l s='Marketplace description' mod='bonaicontent'}</option>
        </select>

        <input type="hidden" id="product_id" name="product_id" value="{$product_id|escape:'htmlall':'UTF-8'}" />
        <input type="hidden" id="iso_code" name="iso_code" value="{$iso_code|escape:'htmlall':'UTF-8'}" />
        <textarea type="text" id="input_keywords" name="keywords_query"
            placeholder="{l s='Keywords:' mod='bonaicontent'}" class="form-control mb-3"></textarea>
        <div class="row align-items-end">
            <div class="col-12 col-xs-12 col-xl-4 completion_number_wrapper" style="display: none;">
                <label for="completion_number">{l s='Number of marketplace descriptions' mod='bonaicontent'}</label>
                <input id="completion_number" class="form-control" name="completion_number" value="1"
                    placeholder="{l s='Number of marketplace descriptions' mod='bonaicontent'}" />
            </div>
            <div id="bonai_button">
                <span class="btn btn-primary">
                    <span class="bonai-icon">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="bonai-stars"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1273_6)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.76 9.64L10 9L7.76 8.36L6.5 5L5.24 8.36L3 9L5.24 9.64L6.5 13L7.76 9.64ZM17.7143 3.2381L16.5 0L15.2857 3.2381L13 4L15.2857 4.7619L16.5 8L17.7143 4.7619L20 4L17.7143 3.2381ZM15.7143 15.2381L14.5 12L13.2857 15.2381L11 16L13.2857 16.7619L14.5 20L15.7143 16.7619L18 16L15.7143 15.2381ZM8.45946 7.48649L6.5 2L4.54054 7.48649L0 9L4.54054 10.5135L6.5 16L8.45946 10.5135L13 9L8.45946 7.48649Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1273_6">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="bonai-loader" viewBox="0 0 24 24" width="20"
                            height="20">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path
                                d="M12 2a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1zm0 15a1 1 0 0 1 1 1v3a1 1 0 0 1-2 0v-3a1 1 0 0 1 1-1zm8.66-10a1 1 0 0 1-.366 1.366l-2.598 1.5a1 1 0 1 1-1-1.732l2.598-1.5A1 1 0 0 1 20.66 7zM7.67 14.5a1 1 0 0 1-.366 1.366l-2.598 1.5a1 1 0 1 1-1-1.732l2.598-1.5a1 1 0 0 1 1.366.366zM20.66 17a1 1 0 0 1-1.366.366l-2.598-1.5a1 1 0 0 1 1-1.732l2.598 1.5A1 1 0 0 1 20.66 17zM7.67 9.5a1 1 0 0 1-1.366.366l-2.598-1.5a1 1 0 1 1 1-1.732l2.598 1.5A1 1 0 0 1 7.67 9.5z"
                                fill="#fff" />
                        </svg>
                    </span>
                    {l s='Generate' mod='bonaicontent'}</span>
            </div>
        </div>
    </div>
    <div id="bonai_popup" class="col-12 col-xs-12"></div>
</div>