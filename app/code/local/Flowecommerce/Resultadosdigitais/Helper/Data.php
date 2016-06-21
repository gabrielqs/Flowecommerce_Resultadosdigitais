<?php

class Flowecommerce_Resultadosdigitais_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getToken() {
        return Mage::getStoreConfig('resultadosdigitais/general/token');
    }

    public function getPrivateToken() {
    	return Mage::getStoreConfig('resultadosdigitais/general/private_token');
    }

    public function isEnabled() {
        return Mage::getStoreConfigFlag('resultadosdigitais/general/enable');
    }

    public function getJsApiUrl() {
        return Mage::getStoreConfig('resultadosdigitais/general/jsapurl');
    }

    public function isAnalyticsEnabled()
    {
        return Mage::getStoreConfigFlag('resultadosdigitais/general/enable_analytics');
    }

    public function getJsAnalyticsUrl() {
        return Mage::getStoreConfig('resultadosdigitais/general/jsanalyticsurl');
    }

    public function getAnalyticsCode() {
        return Mage::getStoreConfig('resultadosdigitais/general/analytics_code');
    }

}