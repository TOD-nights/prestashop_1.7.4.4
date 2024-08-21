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
 * @version     7.0.0
 */

namespace Nexi\NPG\Redirect;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Nexi\Redirect\Error\NPG\APIKey;
use Nexi\Redirect\Error\NPG\CustomerNotFound;
use Nexi\Redirect\Error\NPG\OrderNotFound;
use Nexi\Redirect\Settings;
use Nexi\Utility\CurrencyHelper;
use Nexi\Utility\Helper;
use Nexi\Utility\Logger;

class NPG
{
    /**
     * @var \NexiXPay
     */
    private $module;

    public function __construct(\NexiXPay $module)
    {
        $this->module = $module;
    }

    public static function getAPIKey()
    {
        if (\Configuration::get('NEXINPG_API_KEY')) {
            $key = \Tools::getValue('NEXINPG_API_KEY', \Configuration::get('NEXINPG_API_KEY'));

            if (trim($key) != '') {
                return $key;
            }
        }

        return null;
    }

    public static function getPaymentMethods()
    {
        if (\Configuration::get('NEXINPG_AVAILABLE_METHODS') == null) {
            return [];
        }

        $methods = \Tools::getValue('NEXINPG_AVAILABLE_METHODS', \Configuration::get('NEXINPG_AVAILABLE_METHODS'));

        if ($methods) {
            if (!is_array($methods)) {
                $methods = json_decode($methods, true);
            }
        } else {
            $methods = [];
        }

        return $methods;
    }

    private function getAvailableAPMInfo()
    {
        return [
            'PAGOINCONTO' => [
                'title' => 'PagoinConto',
                'description' => $this->module->l('Simply pay by bank transfer directly from your home banking with PagoinConto', 'npg'),
                'min_amount' => null,
            ],
            'GOOGLEPAY' => [
                'title' => 'Google Pay',
                'description' => $this->module->l('Easily pay with your Google Pay wallet', 'npg'),
                'min_amount' => null,
            ],
            'APPLEPAY' => [
                'title' => 'Apple Pay',
                'description' => $this->module->l('Easily pay with your Apple Pay wallet', 'npg'),
                'min_amount' => null,
            ],
            'BANCOMATPAY' => [
                'title' => 'Bancomat Pay',
                'description' => $this->module->l('Pay via BANCOMAT Pay just by entering your phone number', 'npg'),
                'min_amount' => null,
            ],
            'MYBANK' => [
                'title' => 'MyBank',
                'description' => $this->module->l('Pay securely by bank transfer with MyBank', 'npg'),
                'min_amount' => null,
            ],
            'ALIPAY' => [
                'title' => 'Alipay',
                'description' => $this->module->l('Pay quickly and easily with your AliPay wallet', 'npg'),
                'min_amount' => null,
            ],
            'WECHATPAY' => [
                'title' => 'WeChat Pay',
                'description' => $this->module->l('Pay quickly and easily with your WeChat Pay wallet', 'npg'),
                'min_amount' => null,
            ],
            'GIROPAY' => [
                'title' => 'Giropay',
                'description' => $this->module->l('Pay directly from your bank account with Giropay', 'npg'),
                'min_amount' => 10,
            ],
            'IDEAL' => [
                'title' => 'iDEAL',
                'description' => $this->module->l('Pay directly from your bank account with iDEAL', 'npg'),
                'min_amount' => 10,
            ],
            'BANCONTACT' => [
                'title' => 'Bancontact',
                'description' => $this->module->l('Pay easily with Bancontact', 'npg'),
                'min_amount' => null,
            ],
            'EPS' => [
                'title' => 'EPS',
                'description' => $this->module->l('Real time payment directly from your bank account with EPS', 'npg'),
                'min_amount' => 100,
            ],
            'PRZELEWY24' => [
                'title' => 'Przelewy24',
                'description' => $this->module->l('Secure payment directly from your bank account with Przelewy24', 'npg'),
                'min_amount' => null,
            ],
            'SKRILL' => [
                'title' => 'Skrill',
                'description' => $this->module->l('Pay quickly and easily with your Skrill wallet', 'npg'),
                'min_amount' => null,
            ],
            'SKRILL1TAP' => [
                'title' => 'Skrill 1tap',
                'description' => $this->module->l('Pay in one tap with your Skrill wallet', 'npg'),
                'min_amount' => null,
            ],
            'PAYU' => [
                'title' => 'PayU',
                'description' => $this->module->l('Secure payment directly from your bank account with PayU', 'npg'),
                'min_amount' => 300,
            ],
            'BLIK' => [
                'title' => 'Blik',
                'description' => $this->module->l('Secure payment directly from your home banking with Blik', 'npg'),
                'min_amount' => 100,
            ],
            'MULTIBANCO' => [
                'title' => 'Multibanco',
                'description' => $this->module->l('Secure payment directly from your home banking with Multibanco', 'npg'),
                'min_amount' => null,
            ],
            'SATISPAY' => [
                'title' => 'Satispay',
                'description' => $this->module->l('Pay easily with your Satispay account', 'npg'),
                'min_amount' => null,
            ],
            'AMAZONPAY' => [
                'title' => 'Amazon Pay',
                'description' => $this->module->l('Pay easily with your Amazon account', 'npg'),
                'min_amount' => null,
            ],
            'PAYPAL' => [
                'title' => 'PayPal',
                'description' => $this->module->l('Pay securely with your PayPal account', 'npg'),
                'min_amount' => null,
            ],
            'ONEY' => [
                'title' => 'Oney',
                'description' => $this->module->l('Pay in 3 or 4 installments by credit, debit or Postepay card with Oney', 'npg'),
                'min_amount' => null,
            ],
            'KLARNA' => [
                'title' => 'Klarna',
                'description' => $this->module->l('Pay in 3 installments with Klarna interest-free', 'npg'),
                'min_amount' => null,
            ],
            'PAGODIL' => [
                'title' => 'PagoDil',
                'description' => $this->module->l('Buy now and pay a little by little with PagoDIL', 'npg'),
                'min_amount' => null,
            ],
        ];
    }

    private function getAllowedAPM()
    {
        return array_keys($this->getAvailableAPMInfo());
    }

    private function getAPMInfo($circuit)
    {
        return $this->getAvailableAPMInfo()[$circuit];
    }

    /**
     * extracts cart id from orderId
     *
     * @param string $orderId
     *
     * @return int
     */
    public static function getCartId($orderId)
    {
        $arr_exploded = explode('-', $orderId);

        if (count($arr_exploded) > 1) {
            return (int) $arr_exploded[0];
        }

        throw new \Exception('Invalid orderId');
    }

    /**
     * from cart id creates an orderId
     *
     * @param int $cartId
     *
     * @return string
     */
    public static function calculateOrderId($cartId)
    {
        if (\NexiXPay::isXPayBuild()) {  // if is build variant, an orderId from previous payments for this cart may be saved
            list($reuse, $orderId) = (new \OrderInfo())->canReuseOrderId($cartId);

            if ($reuse && $orderId !== null) {
                return $orderId;
            }
        }

        return Helper::generate_random_id(18, $cartId);
    }

    /**
     * checks if NPG is configured correctly and is available
     *
     * @return bool
     */
    public static function canPay()
    {
        if (!Settings::isGatewayNPG()) {
            return false;
        }

        if (self::getAPIKey() === null) {
            return false;
        }

        if (count(self::getPaymentMethods()) == 0) {
            return false;
        }

        return true;
    }

    public static function resetPaymentMethods()
    {
        \Configuration::updateValue('NEXINPG_AVAILABLE_METHODS', null);
    }

    /**
     * checks if a npg order was created fot the given cart id
     *
     * @param int $cartId
     *
     * @return bool
     */
    public static function isOrder($cartId)
    {
        $orderInfo = (new \OrderInfo())->getOrderByCartId($cartId);

        if ($orderInfo !== null && $orderInfo['order_created']) {
            return true;
        }

        return false;
    }

    /**
     * checks if saved apy key is correct and if it is, enables the module and saves available payment methods
     * if apy key is invalid disables the module and resets the available payment methods
     *
     * @return array
     */
    public function checkApiKey()
    {
        $ret = ['res' => false, 'msg' => ''];

        try {
            $api = new API();

            $methods = $api->getPaymentMethods();

            \Configuration::updateValue('NEXINPG_AVAILABLE_METHODS', json_encode($methods));

            \Configuration::updateValue('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE', time());

            $ret['res'] = true;
        } catch (APIKey $exc) {
            $ret['msg'] = $this->module->l('Invalid API Key.', 'npg');
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc->getMessage());
        }

        if ($ret['res']) {
            \Module::enableByName($this->module->name);
        } else {
            $this->module->disableModule();

            self::resetPaymentMethods();
        }

        return $ret;
    }

    public function isCurrencyValidForApm($currency, $apm)
    {
        $config = Settings::getConfiguration();

        if ($config['multicurrency'] && $apm == 'CARDS') {
            return in_array($currency, CurrencyHelper::getNpgSupportedCurrencyList());
        }

        return $currency == 'EUR';
    }

    /**
     * returns sorted cards' images' links
     *
     * @return array
     */
    public function getSortedImageLinks()
    {
        $methods = self::getPaymentMethods();

        $cards = [
            'MC',
            'MAE',
            'VISA',
            // V Pay
            'AMEX',
            'JCB',
            // UPI
        ];

        $imageList = array_fill(0, count($cards), null);

        foreach ($methods as $apm) {
            if ($apm['paymentMethodType'] != 'CARDS') {
                continue;
            }

            if (!in_array($apm['circuit'], $cards)) {
                continue;
            }

            array_splice($imageList, array_search($apm['circuit'], $cards), 1, [$apm['imageLink']]);
        }

        $imageList = array_filter($imageList);

        return $imageList;
    }

    /**
     * return payment methods to be displayed for the payment gateway
     *
     * @return array
     */
    public function getAPM($context)
    {
        $this->syncPaymentMethods();

        $apmOptions = [];

        if ($this->isCurrencyValidForApm(CurrencyHelper::getCurrencyISOCode($context->cart->id_currency), 'CARDS')) {
            $config = Settings::getConfiguration();

            $paymentLink = $this->module->createModuleLink($this->module->name, 'npg-pay', ['selected_card' => 'CARDS'], true);

            $apmDati = [
                'paymentLink' => $paymentLink,
                'this_path' => $this->module->getPathUri(),
                'description' => $this->module->l('Pay securely by credit, debit and prepaid card. Powered by Nexi.', 'npg'),
                'imageList' => $this->getSortedImageLinks(),
                'userLogged' => $context->customer->isLogged(),
                'oneClick' => $config['oneclick'],
                'contracts' => [],
            ];

            if ($apmDati['userLogged']) {
                $contracts = $this->getOneClickSavedContracts($context->customer->id);

                if ($contracts['has_contracts']) {
                    $apmDati['contracts'] = $contracts['contracts'];
                }
            }

            $templatePath = Helper::get_front_template_path('npg_method.tpl');

            $apmOptions[] = $this->module->getNewPaymentOption(
                $this->module->l('Payments cards', 'npg'),
                $paymentLink,
                null,
                'npg',
                $this->module->fetchTemplate($templatePath, $apmDati),
                true
            );
        }

        return array_merge($apmOptions, $this->getAlternativeMethods($context));
    }

    public function getAlternativeMethods($context)
    {
        $apmOptions = [];

        $methods = self::getPaymentMethods();

        $templatePath = Helper::get_front_template_path('npg_alternative_method.tpl');

        foreach ($methods as $apm) {
            if ($apm['paymentMethodType'] != 'APM') {
                continue;
            }

            if (!in_array($apm['circuit'], $this->getAllowedAPM())) {
                continue;
            }

            if (!$this->isCurrencyValidForApm(CurrencyHelper::getCurrencyISOCode($context->cart->id_currency), $apm['circuit'])) {
                continue;
            }

            $apmDesc = $this->getAPMInfo($apm['circuit']);

            $amount = CurrencyHelper::calculateAmountToMinUnitNPG(
                Helper::getTotalFromCart($context->cart),
                CurrencyHelper::getCurrencyISOCode($context->cart->id_currency)
            );

            if ($apmDesc['min_amount'] != null && $amount < $apmDesc['min_amount']) {
                continue;
            }

            $apmDati['description'] = $apmDesc['description'];

            $apmOptions[] = $this->module->getNewPaymentOption(
                $apmDesc['title'],
                $this->module->createModuleLink($this->module->name, 'npg-pay', ['selected_card' => $apm['circuit']], true),
                $apm['imageLink'],
                $apm['circuit'],
                $this->module->fetchTemplate($templatePath, $apmDati)
            );
        }

        return $apmOptions;
    }

    /**
     * returns the one click contracts saved on npg
     *
     * @param int|string $customerId
     *
     * @return array
     */
    private function getOneClickContracts($customerId)
    {
        $contracts = [];

        try {
            $api = new API();

            $response = $api->getCustomerContract((string) $customerId);

            if (isset($response['contracts']) && count($response['contracts']) > 0) {
                foreach ($response['contracts'] as $contract) {
                    if ($contract['contractType'] == CIT) {
                        $contracts[] = $contract;
                    }
                }
            }
        } catch (CustomerNotFound $exc) {
            Logger::logExceptionError(new \Exception('Customer not found, customerId: ' . $customerId));
        } catch (\Exception $exc) {
            Logger::logExceptionError(new \Exception($exc->getMessage()));
        }

        return [
            'has_contracts' => !empty($contracts),
            'contracts' => $contracts,
        ];
    }

    /**
     * checks if a token is saved on npg and returns it
     *
     * @param string $customerId
     * @param int|string $token
     * @param array $contracts
     *
     * @return bool|array false or contract
     */
    public function isTokenSavedOnNpg($token, $customerId, $contracts = null)
    {
        if ($contracts === null) {
            $retOC = $this->getOneClickContracts($customerId);

            if (!$retOC['has_contracts']) {
                Logger::logExceptionWarning(new \Exception('OneClick contracts not found for customer: ' . $customerId));

                return false;
            }

            $contracts = $retOC['contracts'];
        }

        foreach ($contracts as $contract) {
            if ($contract['contractId'] == $token) {
                return $contract;
            }
        }

        return false;
    }

    /**
     * returns saved and available payment cards
     *
     * @param int|string $customerId
     *
     * @return array
     */
    public function getOneClickSavedContracts($customerId)
    {
        $ret = ['has_contracts' => false, 'contracts' => []];

        $savedTokens = \Contract::getContracts($customerId);

        if ($savedTokens === null) {
            return $ret;
        }

        $retOC = $this->getOneClickContracts($customerId);

        $availableTokens = [];

        if ($retOC['has_contracts']) {
            foreach ($savedTokens as $key => $token) {
                $contract = $this->isTokenSavedOnNpg($token->num_contract, $customerId, $retOC['contracts']);

                if ($contract !== false) {
                    $availableTokens[$key] = (array) $token;
                    $availableTokens[$key]['npg_contract'] = $contract;
                }
            }

            $ret['has_contracts'] = count($availableTokens) > 0;
            $ret['contracts'] = $availableTokens;
        }

        return $ret;
    }

    /**
     * returns the payload for the payment initialization request
     *
     * @return array
     */
    public function getPayload($context, $selectedToken, $saveToken, $selectedCard)
    {
        $cart = $context->cart;

        $orderId = NPG::calculateOrderId($cart->id);

        $currency = CurrencyHelper::getCurrencyISOCode($cart->id_currency);

        $amount = CurrencyHelper::calculateAmountToMinUnitNPG(Helper::getTotalFromCart($cart), $currency);

        $config = Settings::getConfiguration();

        $payload = [
            'order' => [
                'orderId' => (string) $orderId,
                'amount' => (string) $amount,
                'currency' => $currency,
                'description' => 'PS Order: ' . $cart->id,
                'customField' => 'Prestashop ' . \Tools::substr(_PS_VERSION_, 0, 3) . '.x - ' . $this->module->name . ' ' . $this->module->version,
                'customerId' => $cart->id_customer,
            ],
            'paymentSession' => [
                'actionType' => 'PAY',
                'amount' => (string) $amount,
                'recurrence' => [
                    'action' => NO_RECURRING,
                ],
                'exemptions' => 'NO_PREFERENCE',
                'language' => Settings::getPaymentGatewayLanguage($context),
                'resultUrl' => $this->module->createModuleLink($this->module->name, 'npg-return', ['orderId' => $orderId]),
                'cancelUrl' => $this->module->createModuleLink($this->module->name, 'npg-cancel'),
                'notificationUrl' => $this->module->createModuleLink($this->module->name, 'npg-callback'),
            ],
        ];

        if ($selectedCard) {
            $payload['paymentSession']['paymentService'] = $selectedCard;
        }

        if ($config['oneclick']) {
            $payload = $this->getOneClickParams($payload, $cart->id_customer, $selectedToken, $saveToken);
        }

        if ($config['3ds']) {
            $payload = $this->get3dsParams($payload, $cart);
        }

        return $payload;
    }

    /**
     * checks if OneClick is enabled, if it is, sets the required params
     *
     * @param array $config
     * @param array $payload
     * @param int|string $customerId
     *
     * @return array
     */
    private function getOneClickParams($payload, $customerId, $selectedToken, $saveToken)
    {
        $ret = ['res' => false, 'msg' => ''];

        $contractId = null;

        if ($selectedToken && $selectedToken != SELECTED_TOKEN_NEW) {
            $token = \Contract::getContracts($customerId, $selectedToken);

            if ($token == null) {
                throw new \Exception($this->module->l('Invalid selected card', 'npg'));
            }

            $token = (array) $token[0];

            try {
                $api = new API();

                $response = $api->getCustomerContract($customerId);

                $contractFound = false;

                if (isset($response['contracts']) && count($response['contracts']) > 0) {
                    foreach ($response['contracts'] as $contract) {
                        if ($contract['contractType'] == CIT && $contract['contractId'] == $token['num_contract']) {
                            $contractFound = $contract;
                            break;
                        }
                    }
                }

                if ($contractFound !== false) {
                    $payload['paymentSession']['recurrence']['action'] = SUBSEQUENT_PAYMENT;
                    $contractId = $contractFound['contractId'];
                }
            } catch (CustomerNotFound $exc) {
                $ret['msg'] = $this->module->l('Customer not found', 'npg');
            } catch (\Exception $exc) {
                Logger::logExceptionError(new \Exception($exc->getMessage()));

                $ret['msg'] = $this->module->l('Unable to retrive customer info', 'npg');
            }
        } elseif ($saveToken) {
            $payload['paymentSession']['recurrence']['action'] = CONTRACT_CREATION;
            $contractId = \Contract::createNewToken($customerId);
        }

        if ($contractId !== null) {
            $payload['paymentSession']['recurrence']['contractId'] = $contractId;
            $payload['paymentSession']['recurrence']['contractType'] = CIT;
        }

        return $payload;
    }

    /**
     * checks if 3ds is enabled, if it is, sets the required params
     *
     * @param array $config
     * @param array $payload
     * @param \Cart $cart
     *
     * @return array
     */
    public function get3dsParams($payload, $cart)
    {
        $customer = new \Customer($cart->id_customer);

        $s3d = new Secure3D($cart, $customer);

        $payload['order']['customerInfo'] = $s3d->getParams();

        return $payload;
    }

    /**
     * Retrives order information by order id
     *
     * @param string $orderId
     * @param \Shop|null $shop
     *
     * @return array
     */
    public function getOrderInfo($orderId, $shop = null)
    {
        $ret = ['res' => false, 'msg' => ''];

        try {
            $api = new API($shop);

            $response = $api->getOrder($orderId);

            $ret['res'] = true;
            $ret['order_info'] = $response;
        } catch (OrderNotFound $exc) {
            $ret['msg'] = $this->module->l('Order not found', 'npg');
        } catch (\Exception $exc) {
            Logger::logExceptionError(new \Exception($exc->getMessage()));

            $ret['msg'] = $this->module->l('Unable to retrive order info', 'npg');
        }

        return $ret;
    }

    /**
     * returns the authorization operation
     *
     * @param string $orderId
     * @param \Shop|null $shop
     *
     * @return array
     */
    public function getAuthorizationOperation($orderId, $shop = null)
    {
        $ret = $this->getOrderInfo($orderId, $shop);

        if (!$ret['res']) {
            Logger::logExceptionError(new \Exception($ret['msg']));

            return null;
        }

        $foundAuthorization = null;

        if (
            !array_key_exists('operations', $ret['order_info'])
            || !is_array($ret['order_info']['operations'])
            || count($ret['order_info']['operations']) == 0
        ) {
            Logger::logExceptionError(new \Exception('Invalid order information: ' . json_encode($ret['order_info'])));

            return null;
        }

        foreach ($ret['order_info']['operations'] as $operation) {
            if ($operation['operationType'] == AUTHORIZATION) {
                $foundAuthorization = $operation;
                break;
            }
        }

        return $foundAuthorization;
    }

    /**
     * checks if an order can be refunded or payment accounted
     *
     * @param Order $order
     *
     * @return array
     */
    public function getBoDetails($order)
    {
        $ret = ['res' => false, 'dati' => []];

        $orderInfo = (new \OrderInfo())->getOrderByCartId($order->id_cart);

        $retOrderInfo = $this->getOrderInfo($orderInfo['order_id'], \NexiXPay::getShopFromOrder($order));

        if ($retOrderInfo['res']) {
            $ret['res'] = true;

            $ret['dati']['orderInfo'] = $retOrderInfo['order_info'];

            $ret['dati']['canRefund'] = false;
            $ret['dati']['canAccount'] = false;

            // if order status is different from complete refund status, then it is possibile to check for operations and perform a refund
            if (
                $order->getCurrentState() != (int) \Configuration::get('PS_OS_REFUND')
                && $this->getRefundOperationId($retOrderInfo['order_info']['operations']) !== null
            ) {
                $ret['dati']['canRefund'] = true;
            }

            if ($this->getAccountOperationId($retOrderInfo['order_info']['operations']) !== null) {
                $ret['dati']['canAccount'] = true;
            }

            $ret['dati']['accountingOpDesc'] = '';

            if (isset($ret['dati']['orderInfo']['orderStatus']['order'])) {
                $ret['dati']['currencySign'] = CurrencyHelper::getCurrencySign($retOrderInfo['order_info']['orderStatus']['order']['currency']);
                $ret['dati']['currencyLabel'] = CurrencyHelper::getCurrencySign($retOrderInfo['order_info']['orderStatus']['order']['currency']);

                $ret['dati']['orderInfo']['orderStatus']['order']['amountFormatted'] = CurrencyHelper::formatAmountNPG(
                    $ret['dati']['orderInfo']['orderStatus']['order']['amount'],
                    $ret['dati']['orderInfo']['orderStatus']['order']['currency']
                );
            }

            if (isset($ret['dati']['orderInfo']['operations']) && is_array($ret['dati']['orderInfo']['operations'])) {
                foreach ($ret['dati']['orderInfo']['operations'] as $key => $operation) {
                    $ret['dati']['orderInfo']['operations'][$key]['amountFormatted'] = CurrencyHelper::formatAmountNPG($operation['operationAmount'], $operation['operationCurrency']);

                    $ret['dati']['orderInfo']['operations'][$key]['currencySign'] = CurrencyHelper::getCurrencySign($operation['operationCurrency']);
                }
            }
        }

        return $ret;
    }

    /**
     * returns the last authorized operation
     *
     * @param array $operations
     *
     * @return string|null
     */
    private function getRefundOperationId($operations)
    {
        foreach ($operations as $operation) {
            if (!in_array($operation['operationType'], [AUTHORIZATION, CAPTURE])) {
                continue;
            }

            if ($operation['operationResult'] == PAYMENT_S_EXECUTED) {
                return $operation['operationId'];
            }
        }

        return null;
    }

    /**
     * returns the first authorized operation
     *
     * @param array $operations
     *
     * @return string|null
     */
    private function getAccountOperationId($operations)
    {
        $op = null;
        $accountingDone = false;

        foreach (array_reverse($operations) as $operation) {
            if (!in_array($operation['operationType'], [AUTHORIZATION, CAPTURE])) {
                continue;
            }

            if ($op === null && $operation['operationType'] == AUTHORIZATION && $operation['operationResult'] == PAYMENT_S_AUTHORIZED) {
                $op = $operation['operationId'];
            } elseif ($operation['operationType'] == CAPTURE && $operation['operationResult'] == PAYMENT_S_EXECUTED) {
                $accountingDone = true;
            }
        }

        if ($op !== null && !$accountingDone) {
            return $op;
        }

        return null;
    }

    /**
     * refunds amount for order
     *
     * @param int $orderId for PS Order class object
     * @param string|float $amount
     *
     * @return array
     */
    public function refund($orderId, $amount)
    {
        $ret = ['res' => false, 'msg' => ''];

        try {
            $order = new \Order($orderId);

            $orderInfo = (new \OrderInfo())->getOrderByCartId($order->id_cart);

            $shop = \NexiXPay::getShopFromOrder($order);

            $retOrderInfo = $this->getOrderInfo($orderInfo['order_id'], $shop);

            $operationId = $this->getRefundOperationId($retOrderInfo['order_info']['operations']);

            if ($operationId === null) {
                Logger::logExceptionError(new \Exception('Operation related to order could not be found.'));

                throw new \Exception('Operation related to order could not be found.');
            }

            $api = new API($shop);

            $currency = $retOrderInfo['order_info']['orderStatus']['order']['currency'];

            $payload = [
                'amount' => CurrencyHelper::calculateAmountToMinUnitNPG($amount, $currency),
                'currency' => $currency,
            ];

            $api->refund($operationId, $payload);

            // update order status
            $retOrderInfo = $this->getOrderInfo($orderInfo['order_id'], $shop);

            if ($retOrderInfo['res']) {
                if ($retOrderInfo['order_info']['orderStatus']['capturedAmount'] == 0) {    // if capturedAmount is equal to 0, the order has been completly refunded
                    $order->setCurrentState((int) \Configuration::get('PS_OS_REFUND'));
                } elseif ($order->getCurrentState() != (int) \Configuration::get('PS_CHECKOUT_STATE_PARTIAL_REFUND')) {
                    $order->setCurrentState((int) \Configuration::get('PS_CHECKOUT_STATE_PARTIAL_REFUND'));
                }
            }

            $ret['res'] = true;
            $ret['msg'] = $this->module->l('Refund successful', 'npg');
        } catch (\Exception $exc) {
            $ret['msg'] = $this->module->l('Error while proccessing refund operation.', 'npg');
        }

        return $ret;
    }

    /**
     * account amount for order
     *
     * @param int $orderId for PS Order class object
     * @param string|float $amount
     *
     * @return array
     */
    public function account($orderId, $amount)
    {
        $ret = ['res' => false, 'msg' => ''];

        try {
            $order = new \Order($orderId);

            $orderInfo = (new \OrderInfo())->getOrderByCartId($order->id_cart);

            $shop = \NexiXPay::getShopFromOrder($order);

            $retOrderInfo = $this->getOrderInfo($orderInfo['order_id'], $shop);

            $operationId = $this->getAccountOperationId($retOrderInfo['order_info']['operations']);

            if ($operationId === null) {
                Logger::logExceptionError(new \Exception('Operation related to order could not be found.'));

                throw new \Exception('Operation related to order could not be found.');
            }

            $api = new API($shop);

            $currency = $retOrderInfo['order_info']['orderStatus']['order']['currency'];

            $payload = [
                'amount' => CurrencyHelper::calculateAmountToMinUnitNPG($amount, $currency),
                'currency' => $currency,
            ];

            $api->account($operationId, $payload);

            $ret['res'] = true;
            $ret['msg'] = $this->module->l('Account successful', 'npg');
        } catch (\Exception $exc) {
            $ret['msg'] = $this->module->l('Error while proccessing account operation.', 'npg');
        }

        return $ret;
    }

    /**
     * checks if a oneclick token can be saved and saves it
     *
     * @param string $orderId
     * @param int|string $customerId
     * @param array $authorizationOperation
     *
     * @return void
     */
    public function saveOneClickToken($orderId, $customerId, $authorizationOperation)
    {
        try {
            if ($authorizationOperation && $authorizationOperation['paymentMethod'] == 'CARD' && $authorizationOperation['paymentInstrumentInfo'] != '') {
                $token = (new \OrderInfo())->getCardToken($orderId);

                if ($token != null) {
                    if ($this->isTokenSavedOnNpg($token, $customerId) === false) {
                        throw new \Exception('Token not saved not npg, orderId: ' . $orderId . ' - customerId: ' . $customerId);
                    }

                    \Contract::saveContractInfo(
                        $customerId,
                        $token,
                        $authorizationOperation['paymentCircuit'],
                        $authorizationOperation['paymentInstrumentInfo'],
                        $authorizationOperation['additionalData']['cardExpiryDate']
                    );
                }
            }
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc);
        }
    }

    public function deleteContract($customerId, $contractId)
    {
        $ret = ['res' => false, 'msg' => ''];

        try {
            $oToken = new \Contract();

            $token = $oToken->getContractById($contractId);

            if ($token === null) {
                throw new \Exception('Invalid token.');
            }

            $api = new API();

            $api->deactivateContract($token->num_contract);

            $oToken->deleteContract($customerId, $contractId);

            $ret['res'] = true;
            $ret['msg'] = $this->module->l('Card deleted', 'npg');
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc);

            $ret['msg'] = $this->module->l('Error while deleting card.', 'npg');
        }

        return $ret;
    }

    /**
     * every time the checkout page is accessed, payment methods are updated every 2 hours from last updated
     *
     * @return void
     */
    public function syncPaymentMethods()
    {
        if (!\Configuration::get('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE') || \Configuration::get('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE') == '') {
            \Configuration::updateValue('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE', time());
        }

        $lastCheck = (int) \Configuration::get('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE');

        if (time() - $lastCheck < 7200) {
            return;
        }

        \Configuration::updateValue('NEXIXPAY_LAST_NPG_PAYMENT_METHODS_UPDATE', time());

        try {
            $api = new API();

            $methods = $api->getPaymentMethods();

            \Configuration::updateValue('NEXINPG_AVAILABLE_METHODS', json_encode($methods));
        } catch (\Exception $exc) {
            Logger::logExceptionError($exc->getMessage());
        }
    }

    /**
     * return the correct status for the operation result
     *
     * @param string $operationResult
     *
     * @return int|null
     */
    public function getStatusFromAuthorizationOperationResult($operationResult)
    {
        $status = null;

        if (in_array($operationResult, PAYMENT_SUCCESSFUL)) {
            $status = (int) \Configuration::get('PS_OS_PAYMENT');
        } elseif ($operationResult == PAYMENT_S_PENDING) {
            $status = $this->module->getXpayPendingPaymentStatus();
        } elseif (in_array($operationResult, PAYMENT_FAILURE)) {
            $status = (int) \Configuration::get('PS_OS_ERROR');
        }

        return $status;
    }
}
