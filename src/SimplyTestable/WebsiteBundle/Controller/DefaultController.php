<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class DefaultController extends BaseController implements Cacheable, IEFiltered
{   
    
    /**
     * 
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer() {
        return $this->container;
    }
    
    
    
    public function indexAction()
    {        
        $this->getTestListService()->setUser($this->getUserService()->getPublicUser()); 
        
        return $this->getCacheableResponseService()->getCachableResponse(
            $this->getRequest(),
            $this->render('SimplyTestableWebsiteBundle:Default:index.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUserService()->getUser(),
                'is_logged_in' => $this->getUserService()->isLoggedIn(),
                'web_client_urls' => $this->container->getParameter('web_client_urls'),
                'recent_tests' => $this->getTestListService()->getTests()
            ))                
        );
    }
    
    public function plansAction() {
        return $this->defaultPageAction('plans');           
    }

    public function featuresAction() {
        return $this->defaultPageAction('features');            
    }    
    
    public function roadmapAction() {        
        return $this->defaultPageAction('roadmap'); 
    }    
    
    public function fooAction() {        
        return $this->defaultPageAction('foo'); 
    }     
    
    private function defaultPageAction($templateId) {        
        return $this->getCacheableResponseService()->getCachableResponse(
            $this->getRequest(),
            $this->render('SimplyTestableWebsiteBundle:Default:'.$templateId.'.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUserService()->getUser(),
                'is_logged_in' => $this->getUserService()->isLoggedIn(),
                'web_client_urls' => $this->container->getParameter('web_client_urls'),
            ))                
        );         
    }  
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\TestListService
     */
    private function getTestListService() {
        return $this->get('simplytestable.services.testListService');
    }

    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\CacheableResponseService
     */
    private function getCacheableResponseService() {
        return $this->get('simplytestable.services.cacheableResponseService');
    }        
}

