<?php

namespace SimplyTestable\WebsiteBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{   
    
    public function indexAction()
    {        
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:outdatedBrowser');
        }
        
        $cacheValidatorIdentifier = $this->getCacheValidatorIdentifier();        
        $cacheValidatorHeaders = $this->getCacheValidatorHeadersService()->get($cacheValidatorIdentifier);
        
        $response = $this->getCachableResponse(new Response(), $cacheValidatorHeaders);
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }
        
        return $this->getCachableResponse(
            $this->render('SimplyTestableWebsiteBundle:Default:index.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUser(),
                'is_logged_in' => !$this->getUserService()->isPublicUser($this->getUser()),
                'web_client' => $this->container->getParameter('web_client'),                
            )),
            $cacheValidatorHeaders
        );         
    }
    
    public function plansAction() {
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:outdatedBrowser');
        }
        
        $cacheValidatorIdentifier = $this->getCacheValidatorIdentifier();        
        $cacheValidatorHeaders = $this->getCacheValidatorHeadersService()->get($cacheValidatorIdentifier);
        
        $response = $this->getCachableResponse(new Response(), $cacheValidatorHeaders);
        if ($response->isNotModified($this->getRequest())) {
//            return $response;
        }
        
        return $this->getCachableResponse(
            $this->render('SimplyTestableWebsiteBundle:Default:plans.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUser(),
                'is_logged_in' => !$this->getUserService()->isPublicUser($this->getUser()),
                'web_client' => $this->container->getParameter('web_client'),                
            )),
            $cacheValidatorHeaders
        );            
    }

    public function havingProblemsAction() {
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:havingProblems');
        }
        
        return $this->render('SimplyTestableWebsiteBundle:Default:roadmap.html.twig');
    }    
    
    public function roadmapAction() {        
        if ($this->isUsingOldIE()) {
            return $this->forward('SimplyTestableWebsiteBundle:Default:outdatedBrowser');
        }        
        
        $cacheValidatorIdentifier = $this->getCacheValidatorIdentifier();        
        $cacheValidatorHeaders = $this->getCacheValidatorHeadersService()->get($cacheValidatorIdentifier);
        
        $response = $this->getCachableResponse(new Response(), $cacheValidatorHeaders);
        if ($response->isNotModified($this->getRequest())) {
            return $response;
        }
        
        return $this->getCachableResponse(
            $this->render('SimplyTestableWebsiteBundle:Default:roadmap.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUser(),
                'is_logged_in' => !$this->getUserService()->isPublicUser($this->getUser()),
                'web_client' => $this->container->getParameter('web_client'),                
            )),
            $cacheValidatorHeaders
        );
    }
    
    public function outdatedBrowserAction() {
        return $this->render('SimplyTestableWebsiteBundle:Default:outdated-browser.html.twig');
    }
    
    /**
     * 
     * @return boolean
     */
    public function isUsingOldIE() {        
        if ($this->isUsingIE6() || $this->isUsingIE7()) {
            $this->get('logger')->err('Detected old IE for ['.$_SERVER['HTTP_USER_AGENT'].']');            
            return true;
        }
        
        return false;
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function isUsingIE6() {        
        if (!preg_match('/msie 6\.[0-9]+/i', $_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        
        if (preg_match('/opera/i', $_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function isUsingIE7() {        
        if (!preg_match('/msie 7\.[0-9]+/i', $_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\TestimonialService
     */
    private function getTestimonialService() {
        return $this->get('simplytestable.services.testimonialService');
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isLoggedIn() {
        return !$this->getUserService()->isPublicUser($this->getUser());
    }    
}

