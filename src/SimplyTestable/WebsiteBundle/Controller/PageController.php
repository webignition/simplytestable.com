<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;

class PageController extends BaseController implements Cacheable, IEFiltered
{       
    public function plansAction() {
        return $this->renderCacheableResponse();
    }

    public function featuresAction() {
        return $this->renderCacheableResponse();          
    }    
    
    public function roadmapAction() {        
        return $this->renderCacheableResponse();
    }    
    
    public function accountBenefitsAction() {        
        return $this->renderCacheableResponse();
    }
}

