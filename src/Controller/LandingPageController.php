<?php

namespace App\Controller;

use App\Services\CacheableResponseFactory;
use App\Services\ViewRenderService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class LandingPageController
{
    const ONE_YEAR_IN_SECONDS = 31536000;

    /**
     * @var string[]
     */
    private $validCoupons = [
        'TMS'
    ];

    public function indexAction(
        CacheableResponseFactory $cacheableResponseFactory,
        ViewRenderService $viewRenderService,
        RouterInterface $router,
        Request $request
    ): Response {
        $requestRoute = $request->attributes->get('_route');
        $coupon = strtoupper(str_replace('landingpage_', '', $requestRoute));
        $isValidCoupon = in_array($coupon, $this->validCoupons);

        if (!$isValidCoupon) {
            return new RedirectResponse($router->generate('home_index'));
        }

        $response = $cacheableResponseFactory->createResponse($request, []);

        if (Response::HTTP_NOT_MODIFIED === $response->getStatusCode()) {
            return $response;
        }

        $response = $viewRenderService->renderResponseWithDefaultViewParameters(
            'Page/tms.html.twig',
            [],
            $response
        );

        $cookie = new Cookie(
            'simplytestable-coupon-code',
            $coupon,
            time() + self::ONE_YEAR_IN_SECONDS,
            '/',
            '.simplytestable.com',
            false,
            true
        );

        $response->headers->setCookie($cookie);

        return $response;
    }
}
