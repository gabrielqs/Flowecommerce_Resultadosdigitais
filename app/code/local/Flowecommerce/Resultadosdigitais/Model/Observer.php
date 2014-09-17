<?php

class Flowecommerce_Resultadosdigitais_Model_Observer {

    protected $_api    = null;
    protected $_helper = null;

    const LEAD_CONTACTFORM          = 'contact-form';
    const LEAD_ORDERPLACE           = 'order-place';
    const LEAD_ACCOUNTCREATE        = 'account-create';
    const LEAD_NEWSLETTERSUBSCRIBE  = 'newsletter-subscribe';

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
            if ($customer->getFpjTipoPessoa() == 2) {
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
            }
            if ($uf) {
                $data->setUf($uf);
            }

            $this->_getApi()->addLeadConversion(self::LEAD_ORDERPLACE, $data);
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