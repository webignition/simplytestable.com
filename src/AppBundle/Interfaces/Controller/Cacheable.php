<?php

namespace AppBundle\Interfaces\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param Response $response
     */
    public function setResponse(Response $response);

    /**
     * @return Response
     */
    public function getResponse();

    /**
     * @return bool
     */
    public function hasResponse();
}
