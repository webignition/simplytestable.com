<?php

namespace App\Controller;

use App\Services\CacheableResponseFactory;
use App\Services\DecoratedPlanFactory;
use App\Services\PlansService;
use App\Services\ViewRenderService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class PlanDetailsController
{
    /**
     * @var string[]
     */
    private $allowedPlanNames = array(
        'demo',
        'free',
        'personal',
        'agency',
        'business',
        'enterprise',
        'premium',
    );

    public function indexAction(
        CacheableResponseFactory $cacheableResponseFactory,
        ViewRenderService $viewRenderService,
        RouterInterface $router,
        Request $request,
        PlansService $plansService,
        $name
    ): Response {
        $planName = strtolower($name);

        $isAllowedPlanName = in_array($name, $this->allowedPlanNames);
        if (!$isAllowedPlanName) {
            return new RedirectResponse($router->generate('page_plans'));
        }

        if ($name == 'premium') {
            return new RedirectResponse($router->generate(
                'plandetails_index',
                [
                    'name' => 'agency',
                ]
            ));
        }

        $response = $cacheableResponseFactory->createResponse($request, [
            'plan' => $planName,
        ]);

        if (Response::HTTP_NOT_MODIFIED === $response->getStatusCode()) {
            return $response;
        }

        $plans = DecoratedPlanFactory::decorateCollection($plansService->getPlans($this->allowedPlanNames));
        $plan = $plans[$planName];

        $response = $viewRenderService->renderResponseWithDefaultViewParameters(
            'Page/PlanDetails/' . $planName . '.html.twig',
            [
                'plans' => $plans,
                'plan' => $plan,
                'distinctions' => $plansService->getDistinctions(),
            ],
            $response
        );

        return $response;
    }
}
