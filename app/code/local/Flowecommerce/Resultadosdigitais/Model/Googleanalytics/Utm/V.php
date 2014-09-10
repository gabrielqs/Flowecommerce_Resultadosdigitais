<?php

/**
 * This class represents the __utmv cookie.
 *
 * The __utmv cookie stores Customvars.
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_V {

    private $domain_hash;

    private $custom_vars;

    private $is_valid;

    public function __construct($__utmv) {
        $this->is_valid = false;
        $this->parse($__utmv);
    }

    public function parse($__utmv) {
        $this->custom_vars = array();

        if(!$this->validate($__utmv))
            return;

        $this->is_valid = true;

        list($this->domain_hash, $custom_var_string) = preg_split('[\|]', $__utmv);

        $custom_vars = array_map(function($v) { return preg_split('[\=]', $v); }, preg_split('[\^]', $custom_var_string));

        foreach($custom_vars as $custom_var) {
            $this->custom_vars[] = Mage::getModel('resultadosdigitais/googleanalytics_customvar', array('custom_var', $custom_var));
        }

    }

    public function isValid() {
        return $this->isValid();
    }

    public function validate($__utmv) {
        return preg_match('/^\d+\.\|+(\d=\S+=\S+=\d\^*)/', $__utmv);
    }

    /**
     * The domain hash allows you to track multiple
     * subdomains with the same tracking code.
     *
     * @param string $domain_hash
     */
    public function setDomainHash($domain_hash) {
        $this->domain_hash = $domain_hash;
    }

    /**
     * The domain hash allows you to track multiple
     * subdomains with the same tracking code.
     *
     * @return string $domain_hash
     */
    public function getDomainHash() {
        return $this->domain_hash;
    }

    /**
     * @return array $custom_vars
     */
    public function getCustomvars() {
        return $this->custom_vars;
    }

}
