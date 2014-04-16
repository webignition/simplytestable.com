<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{   

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
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\TestimonialService
     */
    protected function getTestimonialService() {
        return $this->get('simplytestable.services.testimonialService');
    } 
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\CacheableResponseService
     */
    protected function getCacheableResponseService() {
        return $this->get('simplytestable.services.cacheableResponseService');
    }     
}

