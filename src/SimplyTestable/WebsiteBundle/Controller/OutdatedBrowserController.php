<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;

class OutdatedBrowserController extends BaseController implements Cacheable
{   
    
    public function indexAction()
    {  
        return $this->getCacheableResponseService()->getCachableResponse(
            $this->getRequest(),
            $this->render('SimplyTestableWebsiteBundle:Default:outdated-browser.html.twig', array(
                'testimonial' => $this->getTestimonialService()->getRandom(),
                'user' => $this->getUserService()->getUser(),
                'is_logged_in' => $this->getUserService()->isLoggedIn(),
                'web_client_urls' => $this->container->getParameter('web_client_urls'),
            ))                
        );
    }
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\CacheableResponseService
     */
    private function getCacheableResponseService() {
        return $this->get('simplytestable.services.cacheableResponseService');
    }      
}

