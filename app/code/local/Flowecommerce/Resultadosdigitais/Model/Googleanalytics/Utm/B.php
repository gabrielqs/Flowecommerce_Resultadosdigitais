<?php

/**
 * This class represents the __utmb cookie.
 *
 * Description from Google(r):
 *
 * This cookie is used to establish and continue a user session with your site.
 * When a user views a page on your site, the Google Analytics code attempts 
 * to update this cookie. If it does not find the cookie, a new one is written 
 * and a new session is established. Each time a user visits a different page 
 * on your site, this cookie is updated to expire in 30 minutes, thus 
 * continuing a single session for as long as user activity continues within 
 * 30-minute intervals. This cookie expires when a user pauses on a page on 
 * your site for longer than 30 minutes. You can modify the default length of a
 * user session with the _setSessionCookieTimeout() method.
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_B {

    private $domain_hash;

    private $pages_viewed;

    //TODO Need something better here
    private $garbage;

    private $current_session_start;

    private $is_valid;

    public function __construct($__utmb = null) {
        $this->is_valid = false;
        $this->parse($__utmb);
    }

    public function parse($__utmb) {
        if($__utmb == null || empty($__utmb))
            return;

        if(!$this->validate($__utmb))
            return;

        $this->is_valid = true;

        list($domain_hash,$pages_viewed,$garbage,$current_session_start) = preg_split('[\.]', $__utmb);

        $this->setDomainHash($domain_hash);

        $this->setPagesViewed($pages_viewed);

        $this->setCurrentSessionStart(new \DateTime());
        $this->getCurrentSessionStart()->setTimestamp($current_session_start);
    }

    public function isValid() {
        return $this->is_valid;
    }

    public function validate($__utmb) {
        return preg_match('/^\d+\.\d+\.\d+\.\d+/', $__utmb);
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
     * @param int $pages_viewed
     */
    public function setPagesViewed($pages_viewed) {
        $this->pages_viewed = $pages_viewed;
    }

    /**
     * @return int $pages_viewed
     */
    public function getPagesViewed() {
        return $this->pages_viewed;
    }

    /**
     * @param \DateTime $current_session_start
     */
    public function setCurrentSessionStart(\DateTime $current_session_start) {
        $this->current_session_start = $current_session_start;
    }

    /**
     * @return \DateTime $current_session_start
     */
    public function getCurrentSessionStart() {
        return $this->current_session_start;
    }
}
