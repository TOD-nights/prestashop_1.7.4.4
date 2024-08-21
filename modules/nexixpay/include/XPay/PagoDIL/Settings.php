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

namespace Nexi\XPay\Redirect\PagoDIL;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\XPay\Redirect\PagoDIL\Configuration as PagoDILConfiguration;

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

    public function getForm($dati)
    {
        $enabledCategories = $dati['NEXIXPAY_PAGODIL_ENABLED_CATEGORIES'];

        $categoryTree = new \HelperTreeCategories('categories-tree');
        $categoryTree
            ->setUseCheckBox(1)
            ->setInputName('NEXIXPAY_PAGODIL_ENABLED_CATEGORIES')
            ->setSelectedCategories(is_array($enabledCategories) ? $enabledCategories : []);

        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->module->l('Settings PagoDIL', 'settings'),
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Enable PagoDIL', 'settings'),
                        'desc' => $this->module->l('Activate the PagoDIL payment method within the store.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL',
                        'is_bool' => true,
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Minimum cart value', 'settings'),
                        'desc' => $this->module->l('Minimum cart value (in Euro) for which it will be possible to proceed through installment payments with PagoDIL. This value corresponds to the amount set in the XPay back office.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_MIN_CART',
                        'class' => 'nexi-config-input',
                        'disabled' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Maximum cart value', 'settings'),
                        'desc' => $this->module->l('Maximum cart value (in Euro) for which it will be possible to proceed through installment payments with PagoDIL. This value corresponds to the amount set in the XPay back office.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_MAX_CART',
                        'class' => 'nexi-config-input',
                        'disabled' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Number of installments', 'settings'),
                        'desc' => $this->module->l('Number of installments made available for payment via PagoDIL. The rates displayed correspond to the values set in the XPay back office.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_POSSIBLE_INS_VALUES',
                        'class' => 'nexi-config-input',
                        'disabled' => true,
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->module->l('Installment products', 'settings'),
                        'desc' => $this->module->l('Setting up installment products: - For selected categories: select the categories of products of the store that you want to set as payable in installments from the drop-down list below. - All categories: all the products in the store will be configured as payable in installments.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_ENABLE_ON_CATEGORIES',
                        'options' => [
                            'query' => $this->getEnableCategoriesOptions(),
                            'id' => 'key',
                            'name' => 'value',
                        ],
                        'class' => 'nexi-config-input',
                    ],
                    [
                        'type' => 'categories_select',
                        'label' => $this->module->l('Categories', 'settings'),
                        'desc' => $this->module->l('Select the categories on which you want to enable payment via PagoDIL.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_ENABLED_CATEGORIES',
                        'category_tree' => $categoryTree,
                        'class' => 'nexi-config-input widget-properties',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Enter the Tax Code retrieval field', 'settings'),
                        'desc' => $this->module->l('Type the name of the field of your shop that corresponds to the tax code, it will be used by the plugin during the payment phase with PagoDIl: in this way the customer will not have to enter this data manually on the PagoDIL payment page. If the "dni" field is enabled in Prestashop, the plugin will automatically send the value of the "dni" field to PagoDIL, if the customer has filled in the field with a valid tax code.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_TAX_CODE_VAR',
                        'class' => 'nexi-config-input',
                    ],
                    [
                        'type' => 'html',
                        'label' => $this->module->l('Number of products in the cart', 'settings') . ' ' . $this->module->l('(Optional)', 'settings'),
                        'desc' => $this->module->l('Maximum number of products in the cart for which it will be possible to proceed through installment payments with PagoDIL.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_PRODUCT_LIMIT',
                        'html_content' => ''
                            . '<div class="nexi-config-input input-group">'
                            . ' <input '
                            . '     class="form-control" '
                            . '     type="number" '
                            . '     name="NEXIXPAY_PAGODIL_PRODUCT_LIMIT" '
                            . '     id="NEXIXPAY_PAGODIL_PRODUCT_LIMIT" '
                            . '     value="' . $dati['NEXIXPAY_PAGODIL_PRODUCT_LIMIT'] . '">'
                            . '</div>',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('Cofidis product code', 'settings') . ' ' . $this->module->l('(Optional)', 'settings'),
                        'desc' => $this->module->l('If you have more than one Cofidis product code, enter the code that will be used by the plugin for payment via PagoDIL.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_PRODUCT_CODE',
                        'class' => 'nexi-config-input',
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->module->l('Show widget', 'settings'),
                        'desc' => $this->module->l('Enable the PagoDIL widget on products that can be paid in installments. The widget shows information relating to the installment payments made available on the product.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_SHOW_WIDGET',
                        'is_bool' => true,
                        'values' => $this->getDefaultSwitchOptions(),
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->module->l('Number of installments', 'settings'),
                        'desc' => $this->module->l('Number of installments displayed within the widget. It is possible to select only one value (e.g. or 5 interest-free installments).', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_INS_NUMBER',
                        'options' => [
                            'query' => $this->getInstallmentsOptions(),
                            'id' => 'key',
                            'name' => 'value',
                        ],
                        'class' => 'nexi-config-input widget-properties',
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->module->l('Logo type', 'settings'),
                        'desc' => $this->module->l('Select the PagoDIL logo displayed in the widget.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_LOGO_KIND',
                        'options' => [
                            'query' => $this->getLogoOptions(),
                            'id' => 'key',
                            'name' => 'value',
                        ],
                        'class' => 'nexi-config-input widget-properties',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->module->l('"Find out more" link', 'settings'),
                        'desc' => $this->module->l('The PagoDIL widget has an information icon pointing to a predefined web address. It is possible to change the information section by entering a new address in the form.', 'settings'),
                        'name' => 'NEXIXPAY_PAGODIL_LINK',
                        'class' => 'nexi-config-input link-input widget-properties',
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

    private function getDefaultSwitchOptions()
    {
        return [
            [
                'value' => 1,
                'label' => $this->module->l('YES', 'settings'),
            ],
            [
                'value' => 0,
                'label' => $this->module->l('NO', 'settings'),
            ],
        ];
    }

    private function getInstallmentsOptions()
    {
        $pagodilConfig = new PagoDILConfiguration($this->module);

        $installments = $pagodilConfig->getArrayOfInstallmentValues();

        $options = [];

        foreach ($installments as $installment) {
            $options[] = ['key' => $installment, 'value' => $installment];
        }

        return $options;
    }

    private function getLogoOptions()
    {
        return [
            ['key' => 'logo_1', 'value' => $this->module->l('PagoDIL institutional logo', 'settings')],
            ['key' => 'logo_5', 'value' => $this->module->l('White', 'settings')],
        ];
    }

    private function getEnableCategoriesOptions()
    {
        return [
            ['key' => 'selected', 'value' => $this->module->l('For selected categories', 'settings')],
            ['key' => 'all', 'value' => $this->module->l('All categories', 'settings')],
        ];
    }
}
