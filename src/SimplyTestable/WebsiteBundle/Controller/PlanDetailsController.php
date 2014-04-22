<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class PlanDetailsController extends BaseController implements Cacheable, IEFiltered
{       
    private $allowedPlanNames = array(
        'demo',
        'free',
        'personal',
        'agency',
        'business',
        'enterprise'
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
     * @param string $name
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

