<?php

class Flowecommerce_Resultadosdigitais_Model_Observer {

    protected $_api    = null;
    protected $_helper = null;

    /**
     * Tipos de lead
     */
    const LEAD_CONTACTFORM          = 'contact-form';
    const LEAD_ORDERPLACE           = 'order-place';
    const LEAD_ACCOUNTCREATE        = 'account-create';
    const LEAD_NEWSLETTERSUBSCRIBE  = 'newsletter-subscribe';

    /**
     * Cliente tipo pessoa juridica - Compatibilidade com módulo PJ Flow
     */
    const FPJ_PESSOA_JURIDICA_TYPE = 2;

    protected function _getApi() {
        if (is_null($this->_api)) {
            $this->_api = Mage::getModel('resultadosdigitais/api');
        }
        return $this->_api;
    }

    protected function _getGenderLabel($genderId) {
        $return = null;
        $attribute = Mage::getModel('eav/config')->getAttribute('customer', 'gender');
        $allOptions = $attribute->getSource()->getAllOptions(true, true);
        foreach ($allOptions as $instance) {
            if ($instance['value'] == $genderId) {
                $return = $instance['label'];
                break;
            }
        }
        return $return;
    }

    protected function _getHelper() {
        if (is_null($this->_helper)) {
            $this->_helper = Mage::helper('resultadosdigitais');
        }
        return $this->_helper;
    }

    protected function _getRequestDataObject() {
        return Mage::getModel('resultadosdigitais/requestdata');
    }

    protected function _getStoreDataObject() {
        return Mage::app()->getStore();
    }

    public function contactPost(Varien_Event_Observer $observer) {
        if ($this->_getHelper()->isEnabled()) {
            $data = $observer->getData();
            $post = $data['controller_action']->getRequest()->getPost();

            $data = $this->_getRequestDataObject();
            $data->setEmail($post['email']);
            $data->setNome($post['name']);
            $data->setTelefone($post['telephone']);

            $this->_getApi()->addLeadConversion(self::LEAD_CONTACTFORM, $data);
        }
    }

    public function orderPlace(Varien_Event_Observer $observer) {
        if ($this->_getHelper()->isEnabled()) {
            /* @var Mage_Sales_Model_Order $order */
            $order = $observer->getOrder();
            /* @var Mage_Customer_Model_Customer $customer */
            $customer = $order->getCustomer();
            /* @var Mage_Sales_Model_Order_Address $address */
            $address = $order->getBillingAddress();

            $order_value = $order->getGrandTotal();

            /*
             * Dados da conta
             */
            $data = $this->_getRequestDataObject();
            $data->setEmail($customer->getEmail());
            $data->setNome($customer->getName());
            $data->setAniversario($customer->getDob());
            $data->setGender($this->_getGenderLabel($customer->getGender()));
            $data->setCpfCnpj($customer->getTaxvat());


            /*
             * Dados do endereço
             */
            $data->setCidade($address->getCity());
            $data->setTelefone($address->getTelephone());
            $data->setCelular($address->getFax());
            $data->setCep($address->getPostcode());
            $data->setBairro($address->getStreet4());

            # Empresa (verifica se módulo pj da flow está instalado)
            $empresa = false;
            if ($customer->getCompany() == self::FPJ_PESSOA_JURIDICA_TYPE) {
                if ($customer->getFpjRazaoSocial()) {
                    $empresa = $customer->getFpjRazaoSocial();
                }
            } else if ($customer->getCompany()) {
                $empresa = $customer->getCompany();
            }
            if ($empresa) {
                $data->setEmpresa($empresa);
            }

            # Estado, caso esteja definido
            if ($regionId = $address->getRegionId()) {
                /* @var Mage_Directory_Model_Region $region */
                $region = Mage::getModel('directory/region')->load($regionId);
                $uf = $region->getName();
                if ($uf) {
                    $data->setUf($uf);
                }
            }

            # Produtos
            $i = 0;
            /* @var Mage_Sales_Model_Order_Item $item */
            $itemSkus = array();
            $itemNames = array();
            $categoryNames = array();
            foreach($order->getItemsCollection() as $item) {
                $i++;

                /* @var Mage_Catalog_Model_Product $product */
                $product = $item->getProduct();

                $itemSkus[] = $item->getSku();
                $itemNames[] = $item->getName();

                # Categorias dos produtos
                $j = 0;
                /* @var Mage_Catalog_Model_Category $category */
                foreach($product->getCategoryIds() as $categoryId) {
                    $j++;
                    $category = Mage::getModel('catalog/category')->load($categoryId);
                    $categoryNames[] = $category->getName();
                }
            }

            $data->setData('produto_sku', implode(', ', $itemSkus));
            $data->setData('produto_nome', implode(', ', $itemNames));
            $data->setData('produto__categoria', implode(', ', $categoryNames));
            $data->setData('metodo_pagamento', $order->getPayment()->getMethod());
            $data->setData('metodo_entrega', $order->getShippingMethod());

            $this->_getApi()->addLeadConversion(self::LEAD_ORDERPLACE, $data);
            $this->_getApi()->markSale($customer->getEmail(), $order_value);
        }
    }

    public function registerSuccess(Varien_Event_Observer $observer) {
        if ($this->_getHelper()->isEnabled()) {
            /* @var Mage_Customer_Model_Customer $customer */
            $customer = $observer->getCustomer();

            /*
             * Dados da conta
             */
            $data = $this->_getRequestDataObject();
            $data->setEmail($customer->getEmail());
            $data->setNome($customer->getName());
            $data->setAniversario($customer->getDob());
            $data->setGender($this->_getGenderLabel($customer->getGender()));
            $data->setCpfCnpj($customer->getTaxvat());

            $this->_getApi()->addLeadConversion(self::LEAD_ACCOUNTCREATE, $data);
        }
    }

    public function newsletterSubscribe(Varien_Event_Observer $observer) {
        if ($this->_getHelper()->isEnabled()) {
            $subscriber = $observer->getEvent()->getSubscriber();
            if ($subscriber->isSubscribed()) {
                /*
                 * Dados da conta
                 */
                $data = $this->_getRequestDataObject();
                $data->setEmail($subscriber->getEmail());

                $this->_getApi()->addLeadConversion(self::LEAD_NEWSLETTERSUBSCRIBE, $data);
            }
        }
    }
}
