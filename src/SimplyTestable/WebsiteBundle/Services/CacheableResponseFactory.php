<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheableResponseFactory
{
    /**
     * @param Request $request
     * @param Response|null $response
     *
     * @return Response
     */
    public static function createCacheableResponse(Request $request, Response $response = null)
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
}
