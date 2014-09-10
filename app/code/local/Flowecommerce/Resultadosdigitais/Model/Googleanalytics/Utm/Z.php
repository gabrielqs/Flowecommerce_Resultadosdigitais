<?php

/**
 * This class represents the __utmz cookie.
 * 
 * Description from Google(r):
 *
 * This cookie stores the type of referral used by the visitor to reach your 
 * site, whether via a direct method, a referring link, a website search, or a 
 * campaign such as an ad or an email link. It is used to calculate search 
 * engine traffic, ad campaigns and page navigation within your own site. 
 * The cookie is updated with each page view to your site.
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_Z {

    private $domain_hash;

    private $datetime;

    private $session_number;

    private $campaign_number;

    // Fields from campaign_data
    private $campaign_source;

    private $campaign_name;

    private $campaign_medium;

    private $campaign_term;

    /**
     * @param $keywords
     *
     * An array<string> of keywords derived from $campaign_term.
     */
    private $keywords;

    private $campaign_content;

    private $gclid;

    private $is_valid;

    /**
     * @param string $__utmz
     */
    public function __construct($__utmz) {
        $this->parse($__utmz);
    }

    public function isValid() {
        return $this->is_valid;
    }

    public function validate($__utmz) {
        return preg_match('/^\d+\.\d+\.\d+\.\d+\./', $__utmz);
    }

    /**
     * @param string $__utmz
     */
    public function parse($__utmz) {
        $this->is_valid = false;

        if(!$this->validate($__utmz))
            return;

        $this->is_valid = true;

        list($domain_hash,$timestamp, $session_number, $campaign_number, $campaign_data_string) = preg_split('[\.]', $__utmz,5);

        $this->setDomainhash($domain_hash);

        $this->setDateTime(new \DateTime());
        $this->getDateTime()->setTimestamp($timestamp);

        $this->setSessionNumber($session_number);

        $this->setCampaignNumber($campaign_number);

        // Parse the campaign data
        $campaign_data = array();
        parse_str(strtr($campaign_data_string, "|", "&"), $campaign_data);

        if(array_key_exists('utmcsr', $campaign_data))
            $this->setCampaignSource($campaign_data['utmcsr']);

        if(array_key_exists('utmccn', $campaign_data))
            $this->setCampaignName($campaign_data['utmccn']);

        if(array_key_exists('utmcmd', $campaign_data))
            $this->setCampaignMedium($campaign_data['utmcmd']);

        if(array_key_exists('utmctr', $campaign_data) && !empty($campaign_data['utmctr'])) {
            $this->setCampaignTerm($campaign_data['utmctr']);

            $keywords = explode(' ', $this->getCampaignTerm());

            if(count($keywords) > 0)
                $this->setKeywords($keywords); 
        }

        if(array_key_exists('utmcct', $campaign_data))
            $this->setCampaignContent($campaign_data['utmcct']);

        if(array_key_exists('gclid', $campaign_data))
            $this->setGoogleClickId($campaign_data['gclid']);
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
     * @param \DateTime $datetime
     */
    public function setDateTime(\DateTime $datetime = null) {
        $this->datetime = $datetime;
    }

    /**
     * @return \DateTime $datetime
     */
    public function getDateTime() {
        return $this->datetime;
    }

    /**
     * @param int $session_number
     */
    public function setSessionNumber($session_number) {
        $this->session_number = $session_number;
    }

    /**
     * @return int $session_number
     */
    public function getSessionNumber() {
        return $this->session_number;
    }

    /**
     * @param int $campaign_number
     */
    public function setCampaignNumber($campaign_number) {
        $this->campaign_number = $campaign_number;
    }

    /**
     * @return int $campaign_number
     */
    public function getCampaignNumber() {
        return $this->campaign_number;
    }

    /**
     * @param string $campaign_source
     */
    public function setCampaignSource($campaign_source) {
        $this->campaign_source = $campaign_source;
    }

    /**
     * @return string $campaign_source
     */
    public function getCampaignSource() {
        return $this->campaign_source;
    }

    /**
     * @param string $campaign_name
     */
    public function setCampaignName($campaign_name) {
        $this->campaign_name = $campaign_name;
    }

    /**
     * @return string $campaign_name
     */
    public function getCampaignName() {
        return $this->campaign_name;
    }

    /**
     * @param string $campaign_content
     */
    public function setCampaignContent($campaign_content) {
        $this->campaign_content = $campaign_content;
    }

    /**
     * @return string $campaign_content
     */
    public function getCampaignContent() {
        return $this->campaign_content;
    }

    /**
     * @param string $campaign_medium
     */
    public function setCampaignMedium($campaign_medium) {
        $this->campaign_medium = $campaign_medium;
    }

    /**
     * @return string $campaign_medium
     */
    public function getCampaignMedium() {
        return $this->campaign_medium;
    }

    /**
     * String demited list of keywords.
     *
     * @param string $campaign_term
     */
    public function setCampaignTerm($campaign_term) {
        $this->campaign_term = $campaign_term;
    }

    /**
     * Space delimited list of keywords.
     *
     * @return string $campaign_term
     */
    public function getCampaignTerm() {
        return $this->campaign_term;
    }

    /**
     * Array of strings of keywords derived from $campaign_term.
     *
     * @param array $keywords
     */
    public function setKeywords(array $keywords = null) {
        $this->keywords = $keywords;
    }

    /**
     * Array of strings of keywords derived from $campaign_term.
     *
     * @return array $keywords
     */
    public function getKeywords() {
        return $this->keywords;
    }
}
