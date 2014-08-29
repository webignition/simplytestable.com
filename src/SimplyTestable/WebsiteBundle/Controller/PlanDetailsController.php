<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class PlanDetailsController extends CacheableController implements  IEFiltered {
    private $allowedPlanNames = array(
        'demo',
        'free',
        'personal',
        'agency',
        'business',
        'enterprise',
        'premium'
    );
    
    private $name;
    
    public function indexAction($name) {
        $this->name = $name;
        
        if (!$this->isAllowedPlanName()) {            
            return $this->redirect($this->generateUrl('page_plans'));
        }
        
        return $this->renderCacheableResponse(array(
            'prices' => $this->container->getParameter('plans')['pricing'],            
            'features' => $this->getPlanFeaturesService()->getPlanFeatures()[$this->name],
            'plan' => $this->name
        ));
    }
    
    
    protected function getViewFilename() {
        return str_replace('index.', 'index.' . $this->name . '.', parent::getViewFilename());
    }
    
    
    /**
     * 
     * @return boolean
     */
    private function isAllowedPlanName() {
        return in_array($this->name, $this->allowedPlanNames);
    }
    
    
    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\PlanFeaturesService
     */
    private function getPlanFeaturesService() {
        return $this->container->get('simplytestable.services.planFeaturesService');
    }

}

