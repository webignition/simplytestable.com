<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CacheableResponseService
{
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function getCachableResponse(Request $request, Response $response = null)
    {
        if (is_null($response)) {
            $response = new Response();
        }

        $response->setPublic();
        $response->setEtag($request->headers->get('x-cache-validator-etag'));
        $response->setLastModified(new \DateTime($request->headers->get('x-cache-validator-lastmodified')));
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     * @param Response $response
     *
     * @return Response
     */
    public function getUncacheableResponse(Response $response)
    {
        $response->setPublic();
        $response->setMaxAge(0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-cache', true);

        return $response;
    }
}
