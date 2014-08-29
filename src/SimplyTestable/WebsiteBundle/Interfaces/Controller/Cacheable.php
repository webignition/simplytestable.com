<?php

namespace SimplyTestable\WebsiteBundle\Interfaces\Controller;

interface Cacheable {

    public function getCacheValidatorParameters($action);
    public function setRequest(\Symfony\Component\HttpFoundation\Request $request);
    public function getRequest();

}