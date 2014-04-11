<?php

namespace SimplyTestable\WebsiteBundle\Controller;

class RecentTestListController extends BaseController
{   
    
    public function indexAction()
    {   
        $this->getTestListService()->setUser($this->getUserService()->getPublicUser());
        
        return $this->render('SimplyTestableWebsiteBundle:Partials:/homepage/recent-test-list.html.twig', array(
            'web_client_urls' => $this->container->getParameter('web_client_urls'),
            'tests' => $this->getTestListService()->getTests()
        ));
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\TestListService
     */
    private function getTestListService() {
        return $this->get('simplytestable.services.testListService');
    }   
}

