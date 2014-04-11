<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CacheableResponseService {
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCachableResponse(Request $request, Response $response = null) {        
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