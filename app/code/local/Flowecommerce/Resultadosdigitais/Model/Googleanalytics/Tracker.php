<?php

/**
 * This class presents a unified interface to all of the UTM cookies.
 *
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Tracker {

    private $utma;

    private $utmb;

    private $utmc;

    private $utmv;

    private $utmz;
    private $utmzstring;

    /**
     * The constructor takes either:
     *
     * a) $_COOKIE - Normal usage.  The cookie superglobal contains the cookies
     *               set by Google Analytics.
     *
     * b) $_REQUEST ($_GET) - If _getLinkerUrl() is used, the UTM cookies will 
     *               embedded in the query string.
     *
     * @param array $utm Array of UTM parameters (__utm[a, b, c, z and maybe v)
     */
    public function __construct() {
        $utm = $_COOKIE;
        if(array_key_exists('__utma', $utm))
            $this->parseUtmA($utm['__utma']);

        if(array_key_exists('__utmb', $utm))
            $this->parseUtmB($utm['__utmb']);

        if(array_key_exists('__utmc', $utm))
            $this->parseUtmC($utm['__utmc']);

        if(array_key_exists('__utmv', $utm))
            $this->parseUtmV($utm['__utmv']);

        if(array_key_exists('__utmz', $utm))
            $this->parseUtmZ($utm['__utmz']);
    }

    /**
     * @param Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_A $utma
     */
    public function setUtmA(Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_A $utma = null) {
        $this->utma = $utma;
    }

    /**
     * @return Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_A $utma
     */
    public function getUtmA() {
        return $this->utma;
    }

    /**
     * The string as it appears in the cookie.
     *
     * @param string $__utma
     */
    public function parseUtmA($__utma) {
        $this->setUtmA(Mage::getModel('resultadosdigitais/googleanalytics_utm_a',$__utma));
    }

    /**
     * @param Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_B $utmb
     */
    public function setUtmB(Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_B $utmb = null) {
        $this->utmb = $utmb;
    }

    /**
     * @return Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_B $utmb
     */
    public function getUtmB() {
        return $this->utmb;
    }

    /**
     * The string as it appears in the cookie.
     *
     * @param string $__utmb
     */
    public function parseUtmB($__utmb) {
        $this->setUtmB(Mage::getModel('resultadosdigitais/googleanalytics_utm_b', $__utmb));
    }

    /**
     * @param Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_C $utmc
     */
    public function setUtmC(Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_C $utmc) {
        $this->utmc = $utmc;
    }

    /**
     * @return Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_C $utmc
     */
    public function getUtmC() {
        return $this->utmc;
    }

    /**
     * The string as it appears in the cookie.
     *
     * @param string $__utmc
     */
    public function parseUtmC($__utmc) {
        $this->setUtmC(Mage::getModel('resultadosdigitais/googleanalytics_utm_c', $__utmc));
    }

    /**
     * @param Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_V $utmv
     */
    public function setUtmV(Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_V $utmv) {
        $this->utmv = $utmv;
    }

    /**
     * @return Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_V $utmv
     */
    public function getUtmV() {
        return $this->utmv;
    }

    /**
     * The string as it appears in the cookie.
     *
     * @param string $__utmv
     */
    public function parseUtmV($__utmv) {
        $this->setUtmV(Mage::getModel('resultadosdigitais/googleanalytics_utm_v', $__utmv));
    }

    /**
     * @param Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_Z $utmz
     */
    public function setUtmZ(Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_Z $utmz) {
        $this->utmz = $utmz;
    }

    /**
     * @return Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_Z $utmz
     */
    public function getUtmZ() {
        return $this->utmz;
    }

    /**
     * @return string $utmz
     */
    public function getUtmZString() {
        return $this->utmzstring;
    }

    /**
     * The string as it appears in the cookie.
     *
     * @param string $__utmz
     */
    public function parseUtmZ($__utmz) {
        $this->setUtmZ(Mage::getModel('resultadosdigitais/googleanalytics_utm_z', $__utmz));
        $this->utmzstring = $__utmz;
    }

    // BEGIN Accessor Functions for UTMs
    private function _isValid($obj) {
        return $obj && $obj->isValid();
    }

    /**
     * The domain hash allows you to track multiple 
     * subdomains with the same tracking code.
     *
     * @return string $domain_hash
     */
    public function getDomainHash() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getDomainHash() : null;
    }

    /**
     * @return string Visitor ID assigned by the good folks at Google.
     */
    public function getVisitorId() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getVisitorId() : null;
    }

    /**
     * DateTime object representing the initial visit.
     *     
     * @return \DateTime $initial_visit.
     */
    public function getInitialVisit() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getInitialVisit() : null;
    }

    /**
     * DateTime object representing the previous visit.
     *
     * @return \DateTime $previous_visit.
     */
    public function getPreviousVisit() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getPreviousVisit() : null;
    }

    /**
     * DateTime object representing the current visit start.
     *
     * @return \DateTime $current_visit_start.
     */
    public function getCurrentVisit() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getCurrentVisit() : null;
    }

    /**
     * The number of times that the user has left and returned.
     *
     * This means the user either closed the browser or was 
     * inactive on this site for 30mins or more.
     *
     * @return int $session_count
     */
    public function getSessionCount() {
        return $this->_isValid($this->getUtmA()) ? $this->getUtmA()->getSessionCount() : null;
    }

    /**
     * @return int $pages_viewed
     */
    public function getPagesViewed() {
        return $this->_isValid($this->getUtmB()) ? $this->getUtmB()->getPagesViewed() : null;
    }

    /**
     * @return \DateTime $current_session_start
     */
    public function getCurrentSessionStart() {
        return $this->_isValid($this->getUtmB()) ? $this->getUtmB()->getCurrentSessionStart() : null;
    }

    /**
     * Returns an array<GoogleAnalytics\CampaignTracking\Customvar> of custom
     * variables stored in the __utmv cookie.
     *
     * @return array $custom_vars
     */
    public function getCustomvars() {
        return $this->_isValid($this->getUtmV()) ? $this->getUtmV()->getCustomvars() : array();
    }

    /**
     * Timestamp recorded in __utmz
     *
     * @return \DateTime $datetime
     */
    public function getDateTime() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getDateTime() : null;
    }

    /**
     * Session Number as recorded in __utmz
     *
     * @return int $session_number
     */
    public function getSessionNumber() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getSessionNumber() : null;
    }

    /**
     * Number of campaigns that have driven this visitor here.
     *
     * @return int $campaign_number
     */
    public function getCampaignNumber() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignNumber() : null;
    }

    /**
     * @return string $campaign_source
     */
    public function getCampaignSource() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignSource() : null;
    }

    /**
     * @return string $campaign_medium
     */
    public function getCampaignMedium() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignMedium() : null;
    }

    /**
     * @return string $campaign_name
     */
    public function getCampaignName() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignName() : null;
    }

    /**
     *
     */
    public function getCampaignContent() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignContent() : null;
    }

    /**
     * Space delimited list of keywords.
     *
     * @return string $campaign_term
     */
    public function getCampaignTerm() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getCampaignTerm() : null;
    }

    /**
     * Array of strings of keywords derived from $campaign_term.
     *
     * @return array $keywords
     */
    public function getKeywords() {
        return $this->_isValid($this->getUtmZ()) ? $this->getUtmZ()->getKeywords() : array();
    }
}
