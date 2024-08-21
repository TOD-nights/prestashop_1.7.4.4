<?php
/**
*  @author   DHL Italy <dhlecommerceshipping.it@dhl.com>
*  @copyright 2018 DHL Italy
*  @license  http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

class DhlJsonConfig
{
    public function getConfigs()
    {
        $result = array(
            'config' => array()
        );

        $result = $this->addConfigutationToArray($result);
        $result = $this->addOrderInfoToArray($result);

        return $result;
    }

    private function getActivePaymentMethods()
    {
        $paymentModules = PaymentModule::getInstalledPaymentModules();

        $methods = array();

        foreach ($paymentModules as $paymentModule) {
            $methods[$paymentModule['name']] = $this->getPaymentModuleName($paymentModule['name']);
        }

        return $methods;
    }

    private function getPaymentModuleName($module)
    {
        $paymentModuleName = $module;
        $iso = Tools::substr(Context::getContext()->language->iso_code, 0, 2);

        if ($iso == 'en') {
            $config_file = _PS_MODULE_DIR_ . $module . DIRECTORY_SEPARATOR . 'config.xml';
        } else {
            $config_file = _PS_MODULE_DIR_ . $module . DIRECTORY_SEPARATOR . 'config_' . $iso . '.xml';
        }

        if (file_exists($config_file)) {
            $xml_module = @simplexml_load_file($config_file);

            $paymentModuleName = Tools::stripslashes(Translate::getModuleTranslation(
                (string)$xml_module->name,
                Module::configXmlStringFormat($xml_module->displayName),
                (string)$xml_module->name
            ));
        }

        return $paymentModuleName;
    }

    private function getOrderStatuses()
    {
        return array_map(function ($status) {
            return array(
                'value' => $status['id_order_state'],
                'label' => $status['name'],
            );
        }, OrderState::getOrderStates((int)Context::getContext()->language->id));
    }

    private function addConfigutationToArray($result)
    {
        $config = Configuration::get('GSPEDDHL_CONFIGURATION', '{}');
        $json = json_decode($config);

        $cashOnDelivery = array();
        if (isset($json->payment_methods)) {
            $cashOnDelivery = $json->payment_methods;
        }

        if (isset($json->autologin)) {
            $result['config']['token'] = $json->autologin;
        }

        if (isset($json->order_status)) {
            $result['config']['statusToShip'] = $json->order_status;
        }

        if (isset($json->user_code_main)) {
            $result['config']['userCode'] = $json->user_code_main;
        }

        $result['config']['apiBaseUrl'] = Tools::getHttpHost(true) . __PS_BASE_URI__ . 'api';
        $result['config']['paymentMethods'] = $this->getActivePaymentMethods();
        $result['config']['cashOnDelivery'] = $cashOnDelivery;
        $result['config']['platformStatuses'] = $this->getOrderStatuses();

        return $result;
    }

    /**
     * @return Order
    */
    private function getOrder()
    {
        if (Tools::getValue('id_order', false)) {
            $order = new Order(Tools::getValue('id_order'));
            if (Validate::isLoadedObject($order)) {
                return $order;
            }
        }

        return null;
    }

    private function addOrderInfoToArray($result)
    {
        $order = $this->getOrder();

        if ($order) {
            $result['order'] = array(
                'incrementId' => $order->id,
                'paymentMethod' => $order->module,
                'grandTotal' => $order->total_paid,
                'subtotal' => $order->total_products,
                'email' => $order->getCustomer()->email,
                'status' => $order->getCurrentState()
            );

            $languageId = (int)Context::getContext()->language->id;

            $shippingAddress = new Address($order->id_address_delivery, $languageId);
            if (Validate::isLoadedObject($shippingAddress)) {
                $result['order']['shippingAddress'] = array(
                    'firstname' => $shippingAddress->firstname,
                    'lastname' => $shippingAddress->lastname,
                    'address' => $shippingAddress->address1 . ' ' . $shippingAddress->address2,
                    'city' => $shippingAddress->city,
                    'postcode' => $shippingAddress->postcode,
                    'province' => (new State($shippingAddress->id_state))->iso_code,
                    'country' => Country::getIsoById(Country::getIdByName($languageId, $shippingAddress->country)),
                    'phone' => $shippingAddress->phone
                );
            }
        }
        return $result;
    }
}
