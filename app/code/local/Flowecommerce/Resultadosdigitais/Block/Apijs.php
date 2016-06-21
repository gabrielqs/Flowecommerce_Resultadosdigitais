<?php

class Flowecommerce_Resultadosdigitais_Block_Apijs extends Mage_Core_Block_Template {

    public function getCustomerEmail() {
        return $this->helper('customer')->getCustomer()->getEmail();
    }

    public function getJsApiUrl() {
        return $this->helper('resultadosdigitais')->getJsApiUrl();
    }

    public function getTokenPublico() {
        return $this->helper('resultadosdigitais')->getToken();
    }

    public function isTrack() {
        $isLoggedIn = $this->helper('customer')->isLoggedIn();
        $enabled = $this->helper('resultadosdigitais')->isEnabled();
        return $enabled && $isLoggedIn;
    }

    public function getJsAnalyticsUrl() {
        return $this->helper('resultadosdigitais')->getJsAnalyticsUrl();
    }

    public function getAnalyticsCode()
    {
        return $this->helper('resultadosdigitais')->getAnalyticsCode();
    }

    public function isAnalyticsEnabled() {
        return $this->helper('resultadosdigitais')->isAnalyticsEnabled();
    }

}