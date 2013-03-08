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
     * @return \SimplyTestable\WebClientBundle\Model\CacheValidatorIdentifier 
     */
    protected function getCacheValidatorIdentifier(array $parameters = array()) {        
        $identifier = new CacheValidatorIdentifier();
        $identifier->setParameter('route', $this->container->get('request')->get('_route'));
        $identifier->setParameter('user', $this->getUser()->getUsername());
        $identifier->setParameter('is_logged_in', $this->getUserService()->isPublicUser($this->getUser()) ? 'false' : 'true');
        
        foreach ($parameters as $key => $value) {
            $identifier->setParameter($key, $value);
        }
        
        return $identifier;
    }    
    
    
    /**
     *
     * @return \SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService 
     */
    protected function getCacheValidatorHeadersService() {
        return $this->container->get('simplytestable.services.cachevalidatorheadersservice');
    } 
    
    
    /**
     * 
     * @return \SimplyTestable\WebClientBundle\Model\User
     */
    public function getUser() {
        $user = $this->getUserService()->getUser();
        if ($this->getUserService()->isPublicUser($user)) {
            $userCookie = $this->getRequest()->cookies->get('simplytestable-user');
            
            if (!is_null($userCookie)) {
                $user = $this->getUserSerializerService()->unserializedFromString($userCookie);
                if (is_null($user)) {
                    $user = $this->getUserService()->getPublicUser();
                } else {
                    $this->getUserService()->setUser($user);
                }
            }
        }
        
        return $this->getUserService()->getUser();
    }    

    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\UserService
     */
    protected function getUserService() {
        return $this->get('simplytestable.services.userservice');
    }     
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\UserSerializerService
     */
    protected function getUserSerializerService() {
        return $this->get('simplytestable.services.userserializerservice');
    }    
}

