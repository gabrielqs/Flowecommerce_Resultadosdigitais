<?php

/**
 * This class represents the __utmc cookie.
 *
 * Description from Google(r):
 *
 * This cookie is no longer used by the ga.js tracking code to determine 
 * session status.
 *
 * Historically, this cookie operated in conjunction with the __utmb cookie to 
 * determine whether or not to establish a new session for the user. For 
 * backwards compatibility purposes with sites still using the urchin.js 
 * tracking code, this cookie will continue to be written and will expire when 
 * the user exits the browser. However, if you are debugging your site tracking
 * and you use the ga.js tracking code, you should not interpret the existence 
 * of this cookie in relation to a new or expired session. 
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_C {

    private $domain_hash;

    private $is_valid;

    public function __construct($__utmc) {
        $this->is_valid = false;
        $this->parse($__utmc);
    }

    public function parse($__utmc) {
        if(!$this->validate($__utmc))
            return;

        $this->is_valid = true;

        $this->setDomainHash($__utmc);
    }

    public function isValid() {
        return $this->is_valid;
    }

    public function validate($__utmc) {
        return preg_match('/\d+/', $__utmc);
    }

    /**
     * The domain hash allows you to track multiple
     * subdomains with the same tracking code.
     *
     * @return string $domain_hash
     */
    public function setDomainHash($domain_hash) {
        $this->domain_hash = $domain_hash;
    }

    /**
     * The domain hash allows you to track multiple
     * subdomains with the same tracking code.
     *
     * @param string $domain_hash
     */
    public function getDomainHash() {
        return $this->domain_hash;
    }
}
