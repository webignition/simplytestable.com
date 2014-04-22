<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class PageController extends BaseController implements Cacheable, IEFiltered
{       
    public function plansAction() {
        return $this->renderCacheableResponse(array(
            'prices' => $this->container->getParameter('plans')['pricing'],
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
        ));
    }

    public function featuresAction() {
        return $this->renderCacheableResponse();          
    }    
    
    public function roadmapAction() {        
        return $this->renderCacheableResponse();
    }    
    
    public function accountBenefitsAction() {        
        return $this->renderCacheableResponse(array(
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
        ));
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\PlanFeaturesService
     */
    private function getPlanFeaturesService() {
        return $this->container->get('simplytestable.services.planFeaturesService');
    }
    
    
  
}

