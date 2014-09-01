<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;
use Symfony\Component\HttpFoundation\Cookie;

class LandingPageController extends BaseController implements IEFiltered {

    const ONE_YEAR_IN_SECONDS = 31536000;

    private $validCoupons = [
        'TMS'
    ];

    public function indexAction() {
        $response = $this->renderResponse();

        if ($this->hasValidCoupon()) {
            $cookie = new Cookie(
                'simplytestable-coupon-code',
                $this->getCouponFromRoute(),
                time() + self::ONE_YEAR_IN_SECONDS,
                '/',
                '.simplytestable.com',
                false,
                true
            );

            $response->headers->setCookie($cookie);
        }

        return $response;
    }


    /**
     * @return bool
     */
    private function hasValidCoupon() {
        return in_array($this->getCouponFromRoute(), $this->validCoupons);
    }


    /**
     * @return null|string
     */
    private function getCouponFromRoute() {
        if (!$this->get('request')->attributes->has('_route')) {
            return null;
        }

        return strtoupper(str_replace('landingpage_', '', $this->get('request')->attributes->get('_route')));
    }



    
    
  
}

