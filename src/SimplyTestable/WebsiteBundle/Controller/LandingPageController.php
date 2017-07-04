<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class LandingPageController extends BaseController
{
    const ONE_YEAR_IN_SECONDS = 31536000;

    /**
     * @var string[]
     */
    private $validCoupons = [
        'TMS'
    ];

    /**
     * @return Response
     */
    public function indexAction()
    {
        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

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
    private function hasValidCoupon()
    {
        return in_array($this->getCouponFromRoute(), $this->validCoupons);
    }

    /**
     * @return null|string
     */
    private function getCouponFromRoute()
    {
        $requestRoute = $this->get('request_stack')->getCurrentRequest()->attributes->get('_route');

        return strtoupper(str_replace('landingpage_', '', $requestRoute));
    }
}
