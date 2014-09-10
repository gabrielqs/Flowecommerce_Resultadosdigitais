<?php

/**
 * This class represents the __utma cookie.
 *
 * Description from Google(r):
 *
 * This cookie is typically written to the browser upon the first visit to your
 * site from that web browser. If the cookie has been deleted by the browser 
 * operator, and the browser subsequently visits your site, a new __utma cookie 
 * is written with a different unique ID. In most cases, this cookie is used to
 * determine unique visitors to your site and it is updated with each page view. 
 * Additionally, this cookie is provided with a unique ID that Google Analytics 
 * uses to ensure both the validity and accessibility of the cookie as an extra
 * security measure.
 */
class Flowecommerce_Resultadosdigitais_Model_Googleanalytics_Utm_A {

    private $domain_hash;

    private $visitor_id;

    private $initial_visit;

    private $previous_visit;

    private $current_visit;

    private $session_count;

    private $is_valid;

    public function __construct($__utma = null) {
        $this->is_valid = false;
        $this->parse($__utma);
    }

    public function isValid() {
        return $this->is_valid;
    }

    public function parse($__utma) {
        if($__utma == null)
            return;

        if(!$this->validate($__utma))
            return;

        $this->is_valid = true;

        list($domain_hash, $visitor_id, $initial_visit, $previous_visit, $current_visit, $session_count) = preg_split('[\.]', $__utma);

        $this->setDomainHash($domain_hash);
        $this->setVisitorId($visitor_id);

        $this->setInitialVisit(new \DateTime());
        $this->getInitialVisit()->setTimestamp($initial_visit);

        $this->setPreviousVisit(new \DateTime());
        $this->getPreviousVisit()->setTimestamp($previous_visit);

        $this->setCurrentVisit(new \DateTime());
        $this->getCurrentVisit()->setTimestamp($current_visit);

        $this->setSessionCount($session_count);
    }

    private function validate($__utma) {
        return preg_match('/^\d+\.\d+\.\d+\.\d+\.\d+/', $__utma);
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
     * @param string Visitor ID assigned by the good folks at Google.
     */
    public function setVisitorId($visitor_id) {
        $this->visitor_id = $visitor_id;
    }

    /**
     * @return string Visitor ID assigned by the good folks at Google.
     */
    public function getVisitorId() {
        return $this->visitor_id;
    }

    /**
     * DateTime object representing the initial visit.
     *
     * @param \DateTime $initial_visit.
     */
    public function setInitialVisit(\DateTime $initial_visit = null) {
        $this->initial_visit = $initial_visit;
    }

    /**
     * DateTime object representing the initial visit.
     *
     * @return \DateTime $initial_visit.
     */
    public function getInitialVisit() {
        return $this->initial_visit;
    }

    /**
     * DateTime object representing the previous visit.
     *
     * @return \DateTime $previous_visit.
     */
    public function setPreviousVisit(\DateTime $previous_visit = null) {
        $this->previous_visit = $previous_visit;
    }

    /**
     * DateTime object representing the previous visit.
     *
     * @return \DateTime $previous_visit.
     */
    public function getPreviousVisit() {
        return $this->previous_visit;
    }

    /**
     * DateTime object representing the current visit start.
     *
     * @param \DateTime $current_visit_start.
     */
    public function setCurrentVisit(\DateTime $current_visit = null) {
        $this->current_visit = $current_visit;
    }

    /**
     * DateTime object representing the current visit start.
     *
     * @return \DateTime $current_visit_start.
     */
    public function getCurrentVisit() {
        return $this->current_visit;
    }

    /**
     * The number of times that the user has left and returned.
     *
     * This means the user either closed the browser or was
     * inactive on this site for 30mins or more.
     *
     * @param int $session_count
     */
    public function setSessionCount($session_count) {
        $this->session_count = $session_count;
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
        return $this->session_count;
    }
}
