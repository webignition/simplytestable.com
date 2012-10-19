<?php

namespace SimplyTestable\WebsiteBundle\Controller;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;
use SimplyTestable\WebsiteBundle\Model\CacheValidatorIdentifier;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BaseController extends Controller
{
    
    /**
     *
     * @param Response $response
     * @param CacheValidatorHeaders $cacheValidatorHeaders
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    protected function getCachableResponse(Response $response, CacheValidatorHeaders $cacheValidatorHeaders) {
        $response->setPublic();
        $response->setEtag($cacheValidatorHeaders->getETag());
        $response->setLastModified($cacheValidatorHeaders->getLastModifiedDate());        
        
        return $response;
    }
    
    
    /**
     *
     * @return \SimplyTestable\WebsiteBundle\Model\CacheValidatorIdentifier 
     */
    protected function getCacheValidatorIdentifier() {
        $identifier = new CacheValidatorIdentifier();
        $identifier->setParameter('route', $this->container->get('request')->get('_route'));
        
        return $identifier;
    }    
    
    
    /**
     *
     * @return \SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService 
     */
    protected function getCacheValidatorHeadersService() {
        return $this->container->get('simplytestable.services.cachevalidatorheadersservice');
    }     
}

