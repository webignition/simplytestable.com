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
        
        return $this->render('SimplyTestableWebsiteBundle:Default:roadmap.html.twig');
    }
    
    public function outdatedBrowserAction() {
        return $this->render('SimplyTestableWebsiteBundle:Default:outdated-browser.html.twig');
    }
    
    public function isUsingOldIE() {
        try {
            $browserInfo =  $this->container->get('jbi_browscap.browscap')->getBrowser($this->getRequest()->server->get('HTTP_USER_AGENT'));                
            return ($browserInfo->Browser == 'IE' && $browserInfo->MajorVer < 8);                 
        } catch (\Exception $e) {
            return false;
        }
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

