<?php

namespace App\Controller;

use App\Services\DecoratedPlanFactory;
use App\Services\PlansService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PageController extends CacheableController
{
    /**
     * @return Response
     */
    public function homeAction()
    {
        return $this->handleAction('Page/home.html.twig');
    }

    /**
     * @param PlansService $plansService
     *
     * @return Response
     */
    public function plansAction(PlansService $plansService)
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

    /**
     * @return Response
     */
    public function featuresAction()
    {
        return $this->handleAction('Page/features.html.twig');
    }

    /**
     * @param PlansService $plansService
     *
     * @return Response
     */
    public function accountBenefitsAction(PlansService $plansService)
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

    /**
     * {@inheritdoc}
     */
    public function getCacheValidatorParameters($action)
    {
        switch ($action) {
            default:
                return [];
        }
    }

    /**
     * @param string $view
     * @param array $additionalParameters
     *
     * @return RedirectResponse|Response
     */
    private function handleAction($view, $additionalParameters = [])
    {
        if ($this->hasResponse()) {
            return $this->getResponse();
        }

        return $this->render($view, $additionalParameters);
    }
}
