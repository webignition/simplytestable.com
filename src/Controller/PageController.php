<?php

namespace App\Controller;

use App\Services\CacheableResponseFactory;
use App\Services\DecoratedPlanFactory;
use App\Services\PlansService;
use App\Services\ViewRenderService;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class PageController
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var CacheableResponseFactory
     */
    private $cacheableResponseFactory;

    /**
     * @var ViewRenderService
     */
    private $viewRenderService;

    public function __construct(
        RequestStack $requestStack,
        CacheableResponseFactory $cacheableResponseFactory,
        ViewRenderService $viewRenderService
    ) {
        $this->requestStack = $requestStack;
        $this->cacheableResponseFactory = $cacheableResponseFactory;
        $this->viewRenderService = $viewRenderService;
    }

    public function homeAction(): Response
    {
        return $this->handleAction('Page/home.html.twig');
    }

    public function plansAction(PlansService $plansService): Response
    {
        return $this->handleAction(
            'Page/plans.html.twig',
            [
                'plans' => DecoratedPlanFactory::decorateCollection($plansService->getPlans([
                    'personal',
                    'agency',
                    'business',
                ])),
            ]
        );
    }

    public function featuresAction(): Response
    {
        return $this->handleAction('Page/features.html.twig');
    }

    public function accountBenefitsAction(PlansService $plansService): Response
    {
        return $this->handleAction(
            'Page/accountbenefits.html.twig',
            [
                'plans' => DecoratedPlanFactory::decorateCollection($plansService->getPlans([
                    'demo',
                    'premium',
                ])),
                'distinctions' => $plansService->getDistinctions(),
            ]
        );
    }

    public function outdatedBrowserAction(): Response
    {
        return $this->handleAction('Page/outdated-browser.html.twig');
    }

    private function handleAction(string $view, array $viewParameters = []): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $response = $this->cacheableResponseFactory->createResponse($request, []);

        if (Response::HTTP_NOT_MODIFIED === $response->getStatusCode()) {
            return $response;
        }

        $response = $this->viewRenderService->renderResponseWithDefaultViewParameters(
            $view,
            $viewParameters,
            $response
        );

        return $response;
    }
}
