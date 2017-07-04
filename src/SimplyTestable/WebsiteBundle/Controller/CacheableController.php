<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use Symfony\Component\HttpFoundation\Request;

abstract class CacheableController extends AbstractBaseController implements Cacheable
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return (is_null($this->request)) ? $this->get('request_stack')->getCurrentRequest() : $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheValidatorParameters($action)
    {
        return [];
    }
}
