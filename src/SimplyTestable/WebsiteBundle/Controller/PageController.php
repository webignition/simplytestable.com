<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\DecoratedPlanFactory;
use SimplyTestable\WebsiteBundle\Services\PlansService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PageController extends CacheableController
{
    /**
     * @param PlansService $plansService
     *
     * @return Response
     */
    public function plansAction(PlansService $plansService)
    {
        return $this->handleAction([
            'plans' => $plansService->getPlans(),
        ]);
    }

    /**
     * @return Response
     */
    public function featuresAction()
    {
        return $this->handleAction();
    }

    /**
     * @return Response
     */
    public function roadmapAction()
    {
        return $this->handleAction();
    }

    /**
     * @param PlansService $plansService
     *
     * @return Response
     */
    public function accountBenefitsAction(PlansService $plansService)
    {
        return $this->handleAction([
            'plans' => DecoratedPlanFactory::decorateCollection($plansService->getPlans()),
            'distinctions' => $plansService->getDistinctions(),
        ]);
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
     * @param array $additionalParameters
     * @return RedirectResponse|Response
     */
    private function handleAction($additionalParameters = [])
    {
        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

        return $this->renderCacheableResponse($additionalParameters);
    }
}
