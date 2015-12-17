<?php

class Flowecommerce_Resultadosdigitais_Block_Productview extends Flowecommerce_Resultadosdigitais_Block_Apijs {

    public function getIdentificador() {
        return Flowecommerce_Resultadosdigitais_Model_Observer::LEAD_PRODUCTVIEW;
    }

    public function getNomeProduto() {
        return Mage::registry('current_product')->getName();
    }

    public function getSkuProduto() {
        return Mage::registry('current_product')->getSku();
    }
}