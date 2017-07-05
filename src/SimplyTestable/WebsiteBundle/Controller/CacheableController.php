<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class CacheableController extends AbstractBaseController implements Cacheable
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var
     */
    private $response;

    /**
     * {@inheritdoc}
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        return (is_null($this->request)) ? $this->requestStack->getCurrentRequest() : $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function hasResponse()
    {
        return !empty($this->response);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheValidatorParameters($action)
    {
        return [];
    }
}
