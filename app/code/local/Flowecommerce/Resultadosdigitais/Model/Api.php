<?php

class Flowecommerce_Resultadosdigitais_Model_Api
{

    const API_URL_CONVERSIONS = 'https://www.rdstation.com.br/api/1.2/conversions/';
    const API_URL_SERVICES = 'https://www.rdstation.com.br/api/1.2/services/';

    protected $_helper = null;
    protected $_httpClient = null;

    public function markSale($email, $value)
    {
        $return = false;
        try {
            $data = array(
                'status'      => 'won',
                'value'       => $value,
                'email'       => $email,
            );
            $token = $this->_getHelper()->getPrivateToken();
            $url = self::API_URL_SERVICES . "{$token}/generic";
            $leadHttpClient = $this->_getHttpClient();
            $leadHttpClient
                ->resetParameters()
                ->setUri($url)
                ->setMethod(Zend_Http_Client::POST)
                ->setParameterPost($data);
            $response = $leadHttpClient->request();
            $return = $response;
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return $return;
    }

    public function addLeadConversion($conversionIdentifier, Flowecommerce_Resultadosdigitais_Model_Requestdata $data)
    {
        $return = false;
        try {
            if ($this->validateLead($conversionIdentifier, $data)) {
                $data_query = http_build_query($data);

                # Refactor para utilizar zend_http_client
                $leadHttpClient = $this->_getHttpClient();
                $leadHttpClient
                    ->resetParameters()
                    ->setUri(self::API_URL_CONVERSIONS)
                    ->setMethod(Zend_Http_Client::POST)
                    ->setParameterPost($this->_prepareParams($conversionIdentifier, $data));

                $response = $leadHttpClient->request();
                $return = $response;
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return $return;
    }

    protected function _getHelper() {
        if (is_null($this->_helper)) {
            $this->_helper = Mage::helper('resultadosdigitais');
        }
        return $this->_helper;
    }

    protected function _getHttpClient() {
        if (!$this->_httpClient instanceof Varien_Http_Client) {
            $this->_httpClient = new Varien_Http_Client();
        }
        return $this->_httpClient;
    }

    protected function _prepareParams($conversionIdentifier, Flowecommerce_Resultadosdigitais_Model_Requestdata $data) {
        $return = array();

        # formatando valores da requisição
        foreach ($data->getData() as $key => $value) {
            $return[$key] = $value;
        }

        # valores adicionais, adicionaidos por último para garantir que não são sobrescritos pelo que for enviado à API
        $return['token_rdstation'] = $this->_getHelper()->getToken();
        $return['identificador'] = $conversionIdentifier;

        # Código da loja
        $return['store_code'] = Mage::app()->getStore()->getCode();

        # Utmz
        $tracker = Mage::getModel('resultadosdigitais/googleanalytics_tracker');
        if ($utmz = $tracker->getUtmZString()) {
            $return['c_utmz'] = $utmz;
        }
        
        if (!empty($_COOKIE['__trf_src'])) {
    	    $return['traffic_source'] = $_COOKIE['__trf_src'];
        }

        if (!empty($_COOKIE['rdtrk'])) {
            $return['client_id'] = json_decode($_COOKIE['rdtrk'])->{'id'};
        }

        return $return;
    }

    public function validateLead($conversionIdentifier, Flowecommerce_Resultadosdigitais_Model_Requestdata $data) {
        $return = true;

        # Verificando existência de parâmetros obrigatórios
        $token = $this->_getHelper()->getToken();
        if (!$token || !$conversionIdentifier || !$data->getEmail()) {
            $return = false;
        }

        return $return;
    }
}