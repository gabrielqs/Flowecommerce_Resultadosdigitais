<?php

class Flowecommerce_Resultadosdigitais_Block_Categoryview extends Flowecommerce_Resultadosdigitais_Block_Apijs {

    public function getIdentificador() {
        return Flowecommerce_Resultadosdigitais_Model_Observer::LEAD_CATEGORYVIEW;
    }

    public function getNomeCategoria() {
        return Mage::registry('current_category')->getName();
    }
}