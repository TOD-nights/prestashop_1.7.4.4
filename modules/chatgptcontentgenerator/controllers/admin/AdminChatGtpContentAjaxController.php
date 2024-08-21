<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\Module\Chatgptcontentgenerator\Api\Client;
use PrestaShop\Module\Chatgptcontentgenerator\Entity\GptContentGenerator;

class AdminChatGtpContentAjaxController extends ModuleAdminController
{
    private $apiClient;

    public function init()
    {
        parent::init();

        $this->apiClient = new Client(
            $this->module->getConfigGlobal('SHOP_UID')
        );
        $this->apiClient->setToken($this->module->getConfigGlobal('SHOP_TOKEN'));
    }

    public function ajaxProcessProductDescription()
    {
        $name = trim(Tools::getValue('name'));
        if ($name === '') {
            return $this->module->errorResponse(1, 'Product name is empty');
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        $length = Tools::getValue('length');
        if (!is_numeric($length)) {
            $length = 0;
        }

        $idCategoryDefault = (int) Tools::getValue('id_category_default', 0);
        if ($idCategoryDefault == 0) {
            $product = new Product((int) Tools::getValue('id'), false, $language->id);
            $idCategoryDefault = (int) $product->id_category_default;
        }

        $categoryName = null;
        if ($this->module->getConfigGlobal('USE_PRODUCT_CATEGORY', null, 1) == 1 &&
            $idCategoryDefault &&
            $idCategoryDefault != (int) Configuration::get('PS_HOME_CATEGORY')) {
            // get parent categories
            $parentCategories = (new Category($idCategoryDefault, $language->id))
                ->getParentsCategories($language->id);
            if ($parentCategories) {
                // define categories line
                $parentCategories = array_reverse($parentCategories);
                $categoryName = trim(implode(' > ', array_filter(array_column($parentCategories, 'name'))));
            }
        }

        $brandName = null;
        if ((int) $this->module->getConfigGlobal('USE_PRODUCT_BRAND', null, 1) == 1) {
            $brandName = (new Manufacturer((int) Tools::getValue('id_manufacturer')))->name;
        }

        try {
            $description = $this->apiClient->productDescription(
                $name,
                $length,
                $language->iso_code,
                $categoryName,
                $brandName
            );

            $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
            $repository = $container
                ->get('prestashop.module.chatgptcontentgenerator.repository.gptcontentgenerator');
            if ((int) Tools::getValue('id')) {
                $object = $repository->getByProductId((int) Tools::getValue('id'));
                if ($object->getId() == 0) {
                    $object->setIdObject((int) Tools::getValue('id'));
                    $object->setObjectType(GptContentGenerator::TYPE_PRODUCT);
                    $repository->save($object);
                }
            }
        } catch (Exception $e) {
            $this->module->jsonExeptionResponse($e);
        }

        $this->module->jsonResponse([
            'text' => $description['text'],
            'nbWords' => (!isset($description['nbWords'])
                ? str_word_count($description['text'])
                : $description['nbWords']),
            'inQueue' => $description['inQueue'],
            'requestId' => $description['requestId'],
        ]);
    }

    public function ajaxProcessCategoryDescription()
    {
        $name = trim(Tools::getValue('name'));
        if ($name === '') {
            return $this->module->errorResponse(2, 'Category name is empty');
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        $length = Tools::getValue('length');
        if (!is_numeric($length)) {
            $length = 0;
        }

        try {
            $description = $this->apiClient->categoryDescription(
                $name,
                $length,
                $language->iso_code
            );
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([
            'text' => $description['text'],
            'nbWords' => (!isset($description['nbWords'])
                ? str_word_count($description['text'])
                : $description['nbWords']),
            'inQueue' => $description['inQueue'],
            'requestId' => $description['requestId'],
        ]);
    }

    public function ajaxProcessPageContent()
    {
        $name = trim(Tools::getValue('name'));
        if ($name === '') {
            return $this->module->errorResponse(1, 'Page name is empty');
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        $length = Tools::getValue('length');
        if (!is_numeric($length)) {
            $length = 0;
        }

        try {
            $content = $this->apiClient
                ->pageContent($name, $length, $language->iso_code);
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([
            'text' => $content['text'],
            'nbWords' => (!isset($content['nbWords']) ? str_word_count($content['text']) : $content['nbWords']),
            'inQueue' => $content['inQueue'],
            'requestId' => $content['requestId'],
        ]);
    }

    public function ajaxProcessTranslateText()
    {
        $text = trim(Tools::getValue('text'));
        if ($text === '') {
            return $this->module->errorResponse(1, 'The text is empty');
        }

        $text = str_replace(['<br/>', '<br>', '<br />'], "\n", $text);
        $text = strip_tags($text);

        $fromLangauge = trim(Tools::getValue('fromLangauge'));
        if ($fromLangauge === '') {
            return $this->module->errorResponse(1, 'The origin language is not set');
        }
        $toLanguage = trim(Tools::getValue('toLanguage'));
        if ($toLanguage === '') {
            return $this->module->errorResponse(1, 'The target language is not set');
        }

        try {
            $text = $this->apiClient
                ->translateText($text, $fromLangauge, $toLanguage, Tools::getValue('entity'));
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([
            'text' => $text['text'],
            'nbWords' => (!isset($text['nbWords']) ? str_word_count($text['text']) : $text['nbWords']),
            'inQueue' => $text['inQueue'],
            'requestId' => $text['requestId'],
        ]);
    }

    public function ajaxProcessCustomRequest()
    {
        $text = trim(Tools::getValue('text'));
        if ($text === '') {
            return $this->module->errorResponse(1, 'The text is empty');
        }

        $text = str_replace(['<br/>', '<br>', '<br />'], "\n", $text);
        $text = strip_tags($text);

        try {
            $response = $this->apiClient->customRequest($text, Tools::getValue('entity'));
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([
            'text' => $response['text'],
            'nbWords' => (!isset($response['nbWords']) ? str_word_count($response['text']) : $response['nbWords']),
            'inQueue' => (!isset($response['inQueue']) ? false : $response['inQueue']),
            'requestId' => (!isset($response['requestId']) ? 0 : (int) $response['requestId']),
        ]);
    }

    public function ajaxProcessAssociateShop()
    {
        try {
            $shopUid = $this->module->getShopKeyId();

            if (trim($shopUid) === '') {
                throw new Exception('The shop UID is empty.');
            }

            $shopToken = hash('sha256', $shopUid . '.' . _COOKIE_IV_);
            $this->module->setConfigGlobal('SHOP_TOKEN', $shopToken);

            $client = new Client($shopUid);
            $client
                ->setToken($shopToken)
                ->associateShop($shopUid, $shopToken, $this->context->shop);

            $this->module->setConfigGlobal('SHOP_ASSOCIATED', 1);
            $this->module->setConfigGlobal('SHOP_UID', $shopUid);
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([]);
    }

    public function ajaxProcessGetShopInfo()
    {
        try {
            $shopInfo = (new Client($this->module->getConfigGlobal('SHOP_UID')))
                ->setToken($this->module->getConfigGlobal('SHOP_TOKEN'))
                ->getShopInfo()
            ;
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse(['shop' => $shopInfo]);
    }

    public function ajaxProcessGetRequestInfo()
    {
        $id = (int) Tools::getValue('id');

        try {
            $requestInfo = $this->apiClient->sendPostRequest('/requests/info/' . $id);

            if (!isset($requestInfo['success'])) {
                throw new Exception('GetRequestInfo #' . $id . '. Error: unknown response');
            } elseif ($requestInfo['success'] == false) {
                throw new Exception('GetRequestInfo #' . $id . '. ' . $requestInfo['error']['message']);
            }
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse([
            'requestId' => $id,
            'inQueue' => $requestInfo['inQueue'],
            'text' => $requestInfo['text'],
            'nbWords' => $requestInfo['nbWords'],
            'status' => $requestInfo['status'],
        ]);
    }

    public function ajaxProcessBulkProductDescription()
    {
        $replace = Tools::getValue('replace', 1);
        if (!is_numeric($replace)) {
            $replace = 1;
        }

        $ids = Tools::getValue('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        $length = Tools::getValue('length');
        if (!is_numeric($length)) {
            $length = 250;
        }

        $result = [];
        foreach ($ids as $id) {
            $product = new Product($id, false, $language->id);
            if (!Validate::isLoadedObject($product)) {
                return $this->module->errorResponse(
                    2,
                    $this->trans(
                        'The product #%id% could not be loaded',
                        ['%id%' => $id],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }

            $categoryName = null;
            if ($this->module->getConfigGlobal('USE_PRODUCT_CATEGORY', null, 1) == 1 &&
                $product->id_category_default &&
                $product->id_category_default != (int) Configuration::get('PS_HOME_CATEGORY')) {
                // get parent categories
                $parentCategories = (new Category($product->id_category_default, $language->id))
                    ->getParentsCategories($language->id);
                if ($parentCategories) {
                    // define categories line
                    $parentCategories = array_reverse($parentCategories);
                    $categoryName = trim(implode(' > ', array_filter(array_column($parentCategories, 'name'))));
                }
            }

            $brandName = null;
            if ((int) $this->module->getConfigGlobal('USE_PRODUCT_BRAND', null, 1) == 1) {
                $brandName = (new Manufacturer($product->id_manufacturer))->name;
            }

            if (trim($product->name) === '') {
                return $this->module->errorResponse(
                    1,
                    $this->trans(
                        'Product #%id%. Error: name is empty',
                        ['%id%' => $product->id],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }

            try {
                $description = $this->apiClient->productDescription(
                    trim($product->name),
                    $length,
                    $language->iso_code,
                    $categoryName,
                    $brandName
                );
                $result[] = [
                    'idProduct' => (int) $id,
                    'text' => $description['text'],
                    'nbWords' => (!isset($description['nbWords'])
                        ? str_word_count($description['text'])
                        : $description['nbWords']),
                    'inQueue' => $description['inQueue'],
                    'requestId' => $description['requestId'],
                ];

                if ($description['inQueue']) {
                    return $this->module->jsonResponse(['products' => $result]);
                }

                $newDescription = implode(
                    '',
                    array_map(
                        function ($text) {
                            return '<p>' . $text . '</p>';
                        },
                        explode("\n", trim($description['text']))
                    )
                );

                if ($newDescription) {
                    if ($replace) {
                        $product->description = $newDescription;
                    } else {
                        $product->description .= $newDescription;
                    }
                    if ($product->save()) {
                        $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
                        $repository = $container
                            ->get('prestashop.module.chatgptcontentgenerator.repository.gptcontentgenerator');

                        $object = $repository->getByProductId($product->id);
                        if ($object->getId() == 0) {
                            $object->setIdObject((int) $product->id);
                            $object->setObjectType(GptContentGenerator::TYPE_PRODUCT);
                            $repository->save($object);
                        }
                    } else {
                        return $this->module->errorResponse(
                            3,
                            $this->trans(
                                'Product #%id%. Error: description could not be updated',
                                ['%id%' => $product->id],
                                'Modules.Chatgptcontentgenerator.Admin'
                            )
                        );
                    }
                }
            } catch (Exception $e) {
                return $this->module->errorResponse(
                    $e->getCode(),
                    $this->trans(
                        'Product #%id%. Error: %err%',
                        ['%id%' => $id, '%err%' => $e->getMessage()],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }
        }

        return $this->module->jsonResponse(['products' => $result]);
    }

    public function ajaxProcessBulkCategoryDescription()
    {
        $replace = Tools::getValue('replace', 1);
        if (!is_numeric($replace)) {
            $replace = 1;
        }

        $ids = Tools::getValue('ids');
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        $length = 180;

        $result = [];
        foreach ($ids as $id) {
            $category = new Category($id, $language->id);
            if (!Validate::isLoadedObject($category)) {
                return $this->module->errorResponse(
                    2,
                    $this->trans(
                        'The category #%id% could not be loaded',
                        ['%id%' => $id],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }

            if (trim($category->name) === '') {
                return $this->module->errorResponse(
                    1,
                    $this->trans(
                        'Category #%id%. Error: name is empty',
                        ['%id%' => $category->id],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }

            try {
                $description = $this->apiClient->categoryDescription(
                    $category->name,
                    $length,
                    $language->iso_code
                );

                $result[] = [
                    'idCategory' => (int) $category->id,
                    'text' => $description['text'],
                    'nbWords' => (!isset($description['nbWords'])
                        ? str_word_count($description['text'])
                        : $description['nbWords']),
                    'inQueue' => $description['inQueue'],
                    'requestId' => $description['requestId'],
                ];

                if ($description['inQueue']) {
                    return $this->module->jsonResponse(['categories' => $result]);
                }

                $newDescription = implode(
                    '',
                    array_map(
                        function ($text) {
                            return '<p>' . $text . '</p>';
                        },
                        explode("\n", trim($description['text']))
                    )
                );

                if ($newDescription) {
                    if ($replace) {
                        $category->description = $newDescription;
                    } else {
                        $category->description .= $newDescription;
                    }
                    if ($category->save()) {
                        $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
                        $repository = $container
                            ->get('prestashop.module.chatgptcontentgenerator.repository.gptcontentgenerator');

                        $object = $repository->getByCategoryId($category->id);
                        if ($object->getId() == 0) {
                            $object->setIdObject((int) $category->id);
                            $object->setObjectType(GptContentGenerator::TYPE_CATEGORY);
                            $repository->save($object);
                        }
                    } else {
                        return $this->module->errorResponse(
                            3,
                            $this->trans(
                                'Category #%id%. Error: description could not be updated',
                                ['%id%' => $category->id],
                                'Modules.Chatgptcontentgenerator.Admin'
                            )
                        );
                    }
                }
            } catch (Exception $e) {
                $this->module->jsonExeptionResponse($e);
            }
        }

        return $this->module->jsonResponse(['categories' => $result]);
    }

    public function ajaxProcessSetDescription()
    {
        $id = (int) Tools::getValue('id');
        $entity = Tools::getValue('entity');
        $description = Tools::getValue('description');

        $replace = Tools::getValue('replace', 1);
        if (!is_numeric($replace)) {
            $replace = 1;
        }

        $language = $this->context->language;
        if (Tools::getValue('id_language')) {
            $language = new Language((int) Tools::getValue('id_language'));
        }

        try {
            $object = null;
            if ($entity == 'product') {
                $object = new Product($id, false, $language->id);
            } elseif ($entity == 'category') {
                $object = new Category($id, $language->id);
            }

            if (!$object || !Validate::isLoadedObject($object)) {
                throw new Exception('The object could not be loaded');
            }

            $description = implode(
                '',
                array_map(
                    function ($string) {
                        return '<p>' . $string . '</p>';
                    },
                    explode("\n", trim($description))
                )
            );

            if ($replace) {
                $object->description = $description;
            } else {
                $object->description .= $description;
            }
            if ($object->save()) {
                $container = \PrestaShop\PrestaShop\Adapter\SymfonyContainer::getInstance();
                $repository = $container
                    ->get('prestashop.module.chatgptcontentgenerator.repository.gptcontentgenerator');

                if ($entity == 'product') {
                    $node = $repository->getByProductId($object->id);
                } else {
                    $node = $repository->getByCategoryId($object->id);
                }
                if ($node->getId() == 0) {
                    $type = ($entity == 'product'
                        ? GptContentGenerator::TYPE_PRODUCT
                        : GptContentGenerator::TYPE_CATEGORY);

                    $node->setIdObject((int) $object->id);
                    $node->setObjectType($type);
                    $repository->save($node);
                }
            } else {
                return $this->module->errorResponse(
                    3,
                    $this->trans(
                        'Object #%id%. Error: description could not be updated',
                        ['%id%' => $object->id],
                        'Modules.Chatgptcontentgenerator.Admin'
                    )
                );
            }
        } catch (Exception $e) {
            return $this->module->jsonExeptionResponse($e);
        }

        return $this->module->jsonResponse(['success' => true]);
    }
}
