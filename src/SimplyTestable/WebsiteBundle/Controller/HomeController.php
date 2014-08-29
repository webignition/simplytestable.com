<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class HomeController extends CacheableController implements IEFiltered {

    public function indexAction() {
        $this->getTestListService()->setUser($this->getUserService()->getPublicUser());
        
        return $this->renderCacheableResponse(array(
            'recent_tests' => $this->getTestListService()->getTests()            
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
