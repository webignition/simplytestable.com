<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;

abstract class CacheableController extends BaseController implements Cacheable {

    /**
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;


    /**
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest(\Symfony\Component\HttpFoundation\Request $request) {
        $this->request = $request;
    }


    /**
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest() {
        return (is_null($this->request)) ? $this->get('request') : $this->request;
    }


    /**
     * @return array
     */
    public function getCacheValidatorParameters($action) {
        return [];
    }

}

