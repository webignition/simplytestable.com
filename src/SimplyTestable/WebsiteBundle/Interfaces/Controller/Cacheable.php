<?php

namespace SimplyTestable\WebsiteBundle\Interfaces\Controller;

use Symfony\Component\HttpFoundation\Request;

interface Cacheable
{
    /**
     * @param string $action
     *
     * @return array
     */
    public function getCacheValidatorParameters($action);

    /**
     * @param Request $request
     */
    public function setRequest(Request $request);

    /**
     * @return Request
     */
    public function getRequest();
}
