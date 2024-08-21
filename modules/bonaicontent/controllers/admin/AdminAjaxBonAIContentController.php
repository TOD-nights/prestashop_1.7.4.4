<?php
/**
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
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Bonaicontent\Api\Request;

class AdminAjaxBonAIContentController extends ModuleAdminController
{
    private $apiRequest;

    private $settings;

    public function init()
    {
        parent::init();

        $shopUid = $this->module->getShopKeyId();

        $this->apiRequest = new Request($shopUid);

        $this->settings = [
            'title_max' => Configuration::get('BON_AI_TITLE_MAX'),
            'summary_max' => Configuration::get('BON_AI_SUMMARY_MAX'),
            'pr_desc_max' => Configuration::get('BON_AI_PR_DESC_MAX'),
            'pr_meta_title_max' => Configuration::get('BON_AI_PR_META_TITLE_MAX'),
            'pr_meta_desc_max' => Configuration::get('BON_AI_PR_META_DESC_MAX'),
            'cat_meta_desc_max' => Configuration::get('BON_AI_CAT_META_DESC_MAX'),
            'cat_desc_max' => Configuration::get('BON_AI_CAT_DESC_MAX'),
            'marketplac_desc' => Configuration::get('BON_AI_MARKETPLAC_DESC'),
        ];
    }

    public function ajaxProcessShopInfo(): void
    {
        $template = '/bonaicontent/views/templates/hook/bonaicontent-shop-info.tpl';
        $context = Context::getContext();

        $data = [
            'url' => 'https://api.bontheme.com/modules/bonaicontent/api/shop/',
            'plan_name' => Tools::getValue('plan_name'),
        ];

        $request = $this->apiRequest->sendRequest($data);

        if (isset($request['customer_info']) && $request['customer_info']) {
            $context->smarty->assign([
                'result' => $request['customer_info'],
            ]);

            $html = $context->smarty->fetch(_PS_MODULE_DIR_ . $template);

            $this->outputJsonResponse(['result' => $html]);
        } else {
            $this->outputJsonResponse(['error' => 'Customer not found']);
        }
    }

    public function ajaxProcessAdminProducts(): void
    {
        $product_id = Tools::getValue('product_id');
        $iso_code = Tools::getValue('iso_code');
        $controller_name = Tools::getValue('action');
        $bonaicontent_keywords = Tools::getValue('bonaicontent_keywords');
        $content_type = Tools::getValue('content_type');
        $n = Tools::getValue('completion_number');

        if ('productMetaTitle' === $content_type || 'productMetaDescription' === $content_type) {
            $template = '/bonaicontent/views/templates/hook/bonaicontent-product-seo-result.tpl';
        } else {
            $template = '/bonaicontent/views/templates/hook/bonaicontent-product-result.tpl';
        }

        $data = $this->getProductInfo($product_id, $iso_code, $bonaicontent_keywords);

        $response = $this->sendRequestAndGetResponse($data, $iso_code, $content_type, $controller_name, $template, $n);

        $this->outputJsonResponse($response);
    }

    public function ajaxProcessAdminCategories(): void
    {
        $category_id = Tools::getValue('category_id');
        $iso_code = Tools::getValue('iso_code');
        $controller_name = Tools::getValue('action');
        $bonaicontent_keywords = Tools::getValue('bonaicontent_keywords');
        $content_type = Tools::getValue('content_type');
        $n = Tools::getValue('completion_number');

        if ('categoryMetaDescription' === $content_type || 'categoryDescription' === $content_type) {
            $template = '/bonaicontent/views/templates/hook/bonaicontent-category-result.tpl';
        }

        $data = $this->getCategoryInfo($category_id, $iso_code, $bonaicontent_keywords);

        $response = $this->sendRequestAndGetResponse($data, $iso_code, $content_type, $controller_name, $template, $n);

        $this->outputJsonResponse($response);
    }

    private function sendRequestAndGetResponse(array $data, string $iso_code, string $content_type, string $controller_name, string $template, $n = 1): array
    {
        $request = [];

        $data = [
            'data' => $data,
            'settings' => $this->settings,
            'iso_code' => $iso_code,
            'content_type' => $content_type,
            'controller_name' => $controller_name,
            'n' => $n,
            'url' => 'https://api.bontheme.com/modules/bonaicontent/api/content/',
        ];

        $request = $this->apiRequest->sendRequest($data);

        $context = Context::getContext();

        $context->smarty->assign([
            'result' => $request['result'],
            'content_type' => $content_type,
        ]);

        $html = $context->smarty->fetch(_PS_MODULE_DIR_ . $template);

        return ['result' => $html];
    }

    private function outputJsonResponse(array $response)
    {
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function getProductInfo(?int $product_id, string $iso_code, string $bonaicontent_keywords): array
    {
        $language = Context::getContext()->language;
        $product = new Product($product_id, false, $language->id);
        $category = new Category($product->id_category_default, $language->id);
        $features = $product->getFrontFeatures($language->id);

        $data = [
            'product_name' => $product->name,
            'product_name_category_default' => $category->name,
            'product_description' => strip_tags($product->description),
            'product_description_short' => strip_tags($product->description_short),
            'product_features' => [],
            'bonaicontent_keywords' => $bonaicontent_keywords,
        ];

        if (!empty($features)) {
            foreach ($features as $feature) {
                $data['product_features'][] = [
                    'product_features_name' => $feature['name'],
                    'product_features_name_value' => $feature['value'],
                ];
            }
        }

        return $data;
    }

    private function getCategoryInfo(?int $category_id, string $iso_code, string $bonaicontent_keywords): array
    {
        $language = Context::getContext()->language;
        $category = new Category($category_id, $language->id);

        $data = [
            'category_name' => $category->name,
            'bonaicontent_keywords' => $bonaicontent_keywords,
        ];

        return $data;
    }
}
