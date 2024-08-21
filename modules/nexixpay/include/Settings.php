<?php
/**
 * Copyright (c) 2020 Nexi Payments S.p.A.
 *
 * @author      iPlusService S.r.l.
 * @copyright   Copyright (c) 2020 Nexi Payments S.p.A. (https://ecommerce.nexi.it)
 * @license     GNU General Public License v3.0
 *
 * @category    Payment Module
 *
 * @version     5.4.0
 */

namespace Nexi\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\XPay\Redirect\PagoDIL\Settings as PagoDILSettings;

class Settings
{
    /**
     * @var \NexiXPay
     */
    private $module;

    public function __construct(\NexiXPay $module)
    {
        $this->module = $module;
    }

    /**
     * Main configuration form
     *
     * @return array
     */
    public function getNexiXpayForm()
    {
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->module->l('Settings Nexi XPay', 'settings'),
                ],
                'warning' => '<b>' . $this->module->l('WARING:', 'settings') . '</b> <br />'
                    . ' <ul>'
                    . '     <li>'
                    . $this->module->l('For a correct behavior of the module, check in the configuration section of the Nexi back-office that the transaction cancellation in the event of a failed notification is set.', 'settings')
                    . '     </li>'
                    . '     <li>'
                    . $this->module->l('A POST notification by the Nexi servers is sent to the following address, containing information on the outcome of the payment.', 'settings') . ' <br />'
                    . '         <span class="xpay-only-text"><b>' . $this->module->createModuleLink($this->module->name, 'S2S') . '</b></span>'
                    . '         <span class="npg-only-text"><b>' . $this->module->createModuleLink($this->module->name, 'npg-callback') . '</b></span>'
                    . '         <br/>'
                    . $this->module->l('The notification is essential for the functioning of the plugin, it is therefore necessary that it is not blocked or filtered by the site infrastructure.', 'settings')
                    . '     </li>'
                    . ' </ul>',
                'input' => [
                    [
                        'type' => 'select',
                        'label' => $this->module->l('Choose the type of credentials you have available for XPay', 'settings'),
                        'desc' => '- ' . $this->module->l('Select "Alias and MAC Key" option if you received the credentials of the production environment in the Welcome Mail received from Nexi during the activation of the service', 'settings') . '<br />'
                            . '- ' . $this->module->l('Select "APIKey" option if you use the API Key as the credential of the production environment generated from the Back Office XPay. Follow the directions in the developer portal for the correct generation process.', 'settings'),
                        'name' => 'NEXIXPAY_ENABLED_GATEWAY',
                        'options' => [
                            'query' => $this->getGatewayOptions(),
                            'id' => 'key',
                            'name' => 'value',
                        ],
                        'class' => 'nexi-config-input gateway-input',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Alias', 'settings'),
                        'name' => 'NEXIXPAY_ALIAS',
                        'desc' => $this->module->l('Given to Merchant by Nexi.', 'settings'),
                        'size' => 100,
                        'class' => 'nexi-config-input xpay-only',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Key MAC', 'settings'),
                        'name' => 'NEXIXPAY_MAC_KEY',
                        'desc' => $this->module->l('Given to Merchant by Nexi.', 'settings'),
                        'size' => 100,
                        'class' => 'nexi-config-input xpay-only',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('API Key', 'settings'),
                        'name' => 'NEXINPG_API_KEY',
                        'desc' => $this->module->l('Generated from the Back Office XPay. Follow the directions in the developer portal for the correct generation process.', 'settings'),
                        'size' => 100,
                        'class' => 'nexi-config-input npg-only',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Enable TEST Mode', 'settings'),
                        'name' => 'NEXIXPAY_TEST',
                        'is_bool' => true,
                        'desc' => '<span class="xpay-only-text">' . $this->module->l('Please register at', 'settings') . ' <a target="_blank" href="https://ecommerce.nexi.it/area-test">ecommerce.nexi.it/area-test</a> ' . $this->module->l('to get the test credentials.', 'settings') . '</span>'
                        . '<span class="npg-only-text">' . $this->module->l('Please refer to Dev Portal to get access to the Sandbox', 'settings') . '</span>',
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->module->l('Accounting', 'settings'),
                        'name' => 'NEXIXPAY_ACCOUNTING',
                        'desc' => $this->module->l('(PRODUCTION ONLY) The field identifies the collection method that the merchant wants to apply to the single transaction, if valued with:', 'settings') . '<br />'
                            . $this->module->l('- I (immediate) the transaction if authorized is also collected without further intervention by the operator and without considering the default profile set on the terminal.', 'settings') . '<br />'
                            . $this->module->l('- D (deferred) or the field is not inserted the transaction if authorized is managed according to what is defined by the terminal profile', 'settings'),
                        'options' => [
                            'query' => $this->getAccountingOptions(),
                            'id' => 'key',
                            'name' => 'value',
                        ],
                        'class' => 'nexi-config-input xpay-only',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Enable 3D Secure 2', 'settings'),
                        'name' => 'NEXIXPAY_ENABLE_3DSECURE',
                        'is_bool' => true,
                        'desc' => $this->module->l('The new 3D Secure 2 protocol adopted by the main international circuits (Visa, MasterCard, American Express), introduces new authentication methods, able to improve and speed up the cardholder\'s purchase experience.', 'settings') . '<br />'
                            . $this->module->l('By activating this option it is established that the terms and conditions that you submit to your customers, with particular reference to the privacy policy, are foreseen to include the acquisition and processing of additional data provided by the', 'settings')
                            . ' <a class="xpay-only-text" href="https://ecommerce.nexi.it/specifiche-tecniche/3dsecure2/introduzione.html" target="_blank">' . $this->module->l('3D Secure 2 Service', 'settings') . '</a> '
                            . ' <span class="npg-only-text">' . $this->module->l('3D Secure 2 Service', 'settings') . '</span> '
                            . $this->module->l('(for example, shipping and / or invoicing address, payment details). Nexi and the International Circuits use the additional data collected separately for the purpose of fraud prevention', 'settings'),
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Enable OneClick', 'settings'),
                        'name' => 'NEXIXPAY_ENABLE_ONECLICK',
                        'is_bool' => true,
                        'desc' => $this->module->l('Enable Nexi XPay for OneClick payment. Make sure that this option is also enabled on your terminal configuration.', 'settings'),
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Enable Multicurrency', 'settings'),
                        'name' => 'NEXINPG_ENABLE_MULTICURRENCY',
                        'is_bool' => true,
                        'desc' => $this->module->l('Enable this option to make the payment methods available for different currencies. To have the complete list of the supported currencies, please visit the developer Portal. Make sure that this option is also enabled on your terminal configuration.', 'settings'),
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                ],
                'submit' => [
                    'title' => $this->module->l('Save', 'settings'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];

        return $form;
    }

    /**
     * Xpay buld style configuration form
     *
     * @param array $dati
     *
     * @return array
     */
    public function getNexiXpayBuildForm($dati)
    {
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->module->l('Style configuration', 'settings'),
                ],
                'description' => $this->module->l('By using this configurator you can change the look and feel of your module', 'settings'),
                'input' => [
                    [
                        'type' => 'html',
                        'label' => '',
                        'html_content' => $this->getPreviewInput(),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Font family', 'settings'),
                        'desc' => $this->module->l('Font family', 'settings'),
                        'html_content' => $this->getTextInput('NEXIXPAYBUILD_FONT_FAMILY', $dati['NEXIXPAYBUILD_FONT_FAMILY'], 'Arial', 'font-family'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Font size', 'settings'),
                        'desc' => $this->module->l('Font size', 'settings'),
                        'html_content' => $this->getTextInput('NEXIXPAYBUILD_FONT_SIZE', $dati['NEXIXPAYBUILD_FONT_SIZE'], '15px', 'font-size'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Font style', 'settings'),
                        'desc' => $this->module->l('Font style', 'settings'),
                        'html_content' => $this->getSelect('NEXIXPAYBUILD_FONT_STYLE', $dati['NEXIXPAYBUILD_FONT_STYLE'], $this->getFontOptions(), 'normal', 'font-style'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Font variant', 'settings'),
                        'desc' => $this->module->l('Font variant', 'settings'),
                        'html_content' => $this->getSelect('NEXIXPAYBUILD_FONT_VARIANT', $dati['NEXIXPAYBUILD_FONT_VARIANT'], $this->getFontStyleOptions(), 'normal', 'font-variant'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Letter spacing', 'settings'),
                        'desc' => $this->module->l('Space between the characters', 'settings'),
                        'html_content' => $this->getTextInput('NEXIXPAYBUILD_LETTER_SPACING', $dati['NEXIXPAYBUILD_LETTER_SPACING'], '1px', 'letter-spacing'),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Border Color', 'settings'),
                        'html_content' => $this->getBorderColorInput($dati),
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Text Color', 'settings'),
                        'html_content' => $this->getTextColorInput($dati),
                    ],
                ],
                'submit' => [
                    'title' => $this->module->l('Save', 'settings'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];

        return $form;
    }

    /**
     * PagoDIL configuration form
     *
     * @param array $dati
     *
     * @return array
     */
    public function getPagoDILForm($dati)
    {
        $pagoDILSettings = new PagoDILSettings($this->module);

        return $pagoDILSettings->getForm($dati);
    }

    private function getGatewayOptions()
    {
        return [
            ['key' => 'xpay', 'value' => $this->module->l('Alias and MAC Key', 'settings')],
            ['key' => 'npg', 'value' => $this->module->l('APIKey', 'settings')],
        ];
    }

    private function getAccountingOptions()
    {
        return [
            ['key' => 'C', 'value' => $this->module->l('Immediate', 'settings')],
            ['key' => 'D', 'value' => $this->module->l('Deferred', 'settings')],
        ];
    }

    private function getDefaultSwitchOptions()
    {
        return [
            [
                'value' => 1,
                'class' => 'xpay-only',
                'label' => $this->module->l('YES', 'settings'),
            ],
            [
                'value' => 0,
                'class' => 'xpay-only',
                'label' => $this->module->l('NO', 'settings'),
            ],
        ];
    }

    private function getFontOptions()
    {
        return [
            ['key' => 'normal', 'value' => $this->module->l('Normal', 'settings')],
            ['key' => 'italic', 'value' => $this->module->l('Italic', 'settings')],
            ['key' => 'oblique', 'value' => $this->module->l('Oblique', 'settings')],
            ['key' => 'initial', 'value' => $this->module->l('Initial', 'settings')],
            ['key' => 'inherit', 'value' => $this->module->l('Inherit', 'settings')],
        ];
    }

    private function getFontStyleOptions()
    {
        return [
            ['key' => 'normal', 'value' => $this->module->l('Normal', 'Normal')],
            ['key' => 'small-caps', 'value' => $this->module->l('Small caps', 'settings')],
            ['key' => 'initial', 'value' => $this->module->l('Initial', 'settings')],
            ['key' => 'inherit', 'value' => $this->module->l('Inherit', 'settings')],
        ];
    }

    private function getPreviewInput()
    {
        return '
            <style type="text/css" id="dynamicStyle"></style>
            <div class="stylePreview">
                <div class="content-anteprima">
                    <div class="Bricks">
                        <div class="placePan">
                            <div class="input-container">
                                <input
                                    type="tel"
                                    autocomplete="off"
                                    spellcheck="false"
                                    class="common"
                                    maxlength="19"
                                    placeholder="' . $this->module->l('Card Number', 'settings') . '"
                                />
                            </div>
                        </div>

                        <div class="placeExp">
                            <div class="input-container">
                                <input
                                    type="tel"
                                    autocomplete="off"
                                    spellcheck="false"
                                    class="common"
                                    placeholder="' . $this->module->l('MM/YY', 'settings') . '"
                                    maxlength="5"
                                />
                            </div>
                        </div>

                        <div class="placeCvv">
                            <div class="input-container">
                                <input 
                                    type="tel"
                                    autocomplete="off"
                                    spellcheck="false"
                                    class="common"
                                    placeholder="' . $this->module->l('CVV', 'settings') . '"
                                    maxlength="3"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    }

    private function getResetDefaultButton($id, $default)
    {
        return '
            <div
                class="info-helper"
                title="' . $this->module->l('Reset to default value', 'settings') . '"
                data-id="' . $id . '"
                data-default="' . $default . '"
            >
                <i class="icon-refresh"></i>
            </div>';
    }

    private function getTextInput($name, $value, $default, $inputTarget)
    {
        $selectedValue = $default;

        if ($value !== false) {
            $selectedValue = $value;
        }

        return '
            <div class="style-block-input-container nexi-config-input">
                <input
                    type="text"
                    class="styleBlock"
                    id="nexi_' . $name . '"
                    name="' . $name . '"
                    data-input-type="simple"
                    ' . ($inputTarget !== null ? 'data-field="' . $inputTarget . '"' : '') . '
                    value="' . $selectedValue . '"
                />
                ' . $this->getResetDefaultButton('nexi_' . $name, $default) . '
            </div>';
    }

    private function getSelect($name, $value, $options, $default, $inputTarget)
    {
        $selectedValue = $default;

        if ($value !== false) {
            $selectedValue = $value;
        }

        $html = '
            <div class="style-block-input-container nexi-config-input">
                <select
                    class="styleBlock"
                    name="' . $name . '"
                    data-input-type="simple"
                    data-field="' . $inputTarget . '"
                    id="nexi_' . $name . '"
                >';

        foreach ($options as $option) {
            $html .= '<option value="' . $option['key'] . '" ' . ($selectedValue == $option['key'] ? ' selected="true"' : '') . '>' . $option['value'] . '</option>';
        }

        $html .= '
                </select>
                ' . $this->getResetDefaultButton('nexi_' . $name, $default) . '
            </div>';

        return $html;
    }

    private function getBorderColorInput($dati)
    {
        return '
            <div class="row nexi-config-input color-fields">
                <div class="col-xs-6">
                ' . $this->getColorInput('NEXIXPAYBUILD_BORDER_COLOR_DEFAULT', $dati['NEXIXPAYBUILD_BORDER_COLOR_DEFAULT'], $this->module->l('When form is empty or correct', 'settings'), '#cdcdcd', 'border-color', true) . '
                </div>
                <div class="col-xs-6">
                ' . $this->getColorInput('NEXIXPAYBUILD_BORDER_COLOR_ERROR', $dati['NEXIXPAYBUILD_BORDER_COLOR_ERROR'], $this->module->l('When form has error', 'settings'), '#c80000') . '
                </div>
            </div>';
    }

    private function getTextColorInput($dati)
    {
        return '
            <div class="row nexi-config-input color-fields">
                <div class="col-xs-6">
                ' . $this->getColorInput('NEXIXPAYBUILD_TEXT_COLOR_PLACEHOLDER', $dati['NEXIXPAYBUILD_TEXT_COLOR_PLACEHOLDER'], $this->module->l('Placeholder color', 'settings'), '#cdcdcd', 'color') . '
                </div>
                <div class="col-xs-6">
                ' . $this->getColorInput('NEXIXPAYBUILD_TEXT_COLOR_INPUT', $dati['NEXIXPAYBUILD_TEXT_COLOR_INPUT'], $this->module->l('Input color', 'settings'), '#5c5c5c', 'color', true) . '
                </div>
            </div>';
    }

    private function getColorInput($name, $value, $helperText, $default, $inputTarget = null, $simple = false)
    {
        $selectedColor = $default;

        if ($value !== false) {
            $selectedColor = $value;
        }

        return '
            <div>
                <div class="style-block-input-container">
                    <input
                        type="color"
                        class="styleBlock form-control"
                        name="' . $name . '"
                        id="nexi_' . $name . '"
                        ' . ($simple ? 'data-input-type="simple"' : '') . '
                        ' . ($inputTarget !== null ? 'data-field="' . $inputTarget . '"' : '') . '
                        value="' . $selectedColor . '"
                    />
                    ' . $this->getResetDefaultButton('nexi_' . $name, $default) . '
                </div>
                <div class="help-block">
                ' . $helperText . '
                </div>
            </div>';
    }

    public static function getConfiguration($shop = null)
    {
        $idShop = null;
        $idShopGroup = null;

        if ($shop !== null) {
            $idShop = $shop->id;
            $idShopGroup = $shop->id_shop_group;
        }

        return [
            'gateway' => \Configuration::get('NEXIXPAY_ENABLED_GATEWAY', null, $idShopGroup, $idShop),
            'alias' => \Configuration::get('NEXIXPAY_ALIAS', null, $idShopGroup, $idShop),
            'mac_key' => \Configuration::get('NEXIXPAY_MAC_KEY', null, $idShopGroup, $idShop),
            'api_key' => \Configuration::get('NEXINPG_API_KEY', null, $idShopGroup, $idShop),
            'accounting' => \Configuration::get('NEXIXPAY_ACCOUNTING', null, $idShopGroup, $idShop),
            'test_mode' => \Configuration::get('NEXIXPAY_TEST', null, $idShopGroup, $idShop) == 1 ? true : false,
            'oneclick' => \Configuration::get('NEXIXPAY_ENABLE_ONECLICK', null, $idShopGroup, $idShop) == 1 ? true : false,
            '3ds' => \Configuration::get('NEXIXPAY_ENABLE_3DSECURE', null, $idShopGroup, $idShop) == 1 ? true : false,
            'multicurrency' => \Configuration::get('NEXINPG_ENABLE_MULTICURRENCY', null, $idShopGroup, $idShop) == 1 ? true : false,
            'font_family' => \Configuration::get('NEXIXPAYBUILD_FONT_FAMILY', null, $idShopGroup, $idShop),
            'font_size' => \Configuration::get('NEXIXPAYBUILD_FONT_SIZE', null, $idShopGroup, $idShop),
            'font_style' => \Configuration::get('NEXIXPAYBUILD_FONT_STYLE', null, $idShopGroup, $idShop),
            'font_variant' => \Configuration::get('NEXIXPAYBUILD_FONT_VARIANT', null, $idShopGroup, $idShop),
            'letter_spacing' => \Configuration::get('NEXIXPAYBUILD_LETTER_SPACING', null, $idShopGroup, $idShop),
            'border_color_default' => \Configuration::get('NEXIXPAYBUILD_BORDER_COLOR_DEFAULT', null, $idShopGroup, $idShop),
            'border_color_error' => \Configuration::get('NEXIXPAYBUILD_BORDER_COLOR_ERROR', null, $idShopGroup, $idShop),
            'text_color_placeholder' => \Configuration::get('NEXIXPAYBUILD_TEXT_COLOR_PLACEHOLDER', null, $idShopGroup, $idShop),
            'text_color_input' => \Configuration::get('NEXIXPAYBUILD_TEXT_COLOR_INPUT', null, $idShopGroup, $idShop),
        ];
    }

    public static function getPaymentGatewayLanguage($context)
    {
        $language = [
            'it' => 'ITA',
            'fr' => 'FRA',
            'de' => 'GER',
            'es' => 'SPA',
            'jp' => 'JPG',
            'cn' => 'CHI',
            'ar' => 'ARA',
            'ru' => 'RUS',
            'gb' => 'ENG',
            'en' => 'ENG',
            'us' => 'ENG',
            'pr' => 'POR',
        ];

        if (static::isGatewayNPG()) {
            $language['el'] = 'ELL';
        }

        if (\Tools::strtolower($context->language->iso_code) && array_key_exists(\Tools::strtolower($context->language->iso_code), $language)) {
            return $language[\Tools::strtolower($context->language->iso_code)];
        }

        return 'ITA';
    }

    public static function isGatewayNPG()
    {
        return self::getConfiguration()['gateway'] == 'npg';
    }

    public static function isGatewayXPay()
    {
        return self::getConfiguration()['gateway'] == 'xpay';
    }
}
