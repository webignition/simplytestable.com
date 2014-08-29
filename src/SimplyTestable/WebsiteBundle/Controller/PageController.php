<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;
use Symfony\Component\HttpFoundation\Cookie;

class PageController extends CacheableController implements IEFiltered {

    const ONE_YEAR_IN_SECONDS = 31536000;

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

    public function tmsAction() {
        $cookie = new Cookie(
            'simplytestable-coupon-code',
            'TMS',
            time() + self::ONE_YEAR_IN_SECONDS,
            '/',
            '.simplytestable.com',
            false,
            true
        );

        $response = $this->renderCacheableResponse([
            'cookie' => (string)$cookie
        ]);
        $response->headers->setCookie($cookie);

        return $response;
    }


    /**
     * 
     * @return \SimplyTestable\WebsiteBundle\Services\PlanFeaturesService
     */
    private function getPlanFeaturesService() {
        return $this->container->get('simplytestable.services.planFeaturesService');
    }


    public function getCacheValidatorParameters($action) {
        switch  ($action) {
            case 'plansAction':
                return [];

            case 'accountBenefitsAction':
                return [];

            case 'tmsAction':
                return [
                    'has_tms_coupon_code_cookie' => (int)$this->getRequest()->cookies->has('simplytestable-coupon-code')
                ];

            default:
                return [];
        }
    }
    
    
  
}

