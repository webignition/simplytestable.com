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
        return $this->handleAction(
            '@SimplyTestableWebsite/Page/plans.html.twig',
            [
                'plans' => $plansService->getPlans(),
            ]
        );
    }

    /**
     * @return Response
     */
    public function featuresAction()
    {
        return $this->handleAction('@SimplyTestableWebsite/Page/features.html.twig');
    }

    /**
     * @return Response
     */
    public function roadmapAction()
    {
        return $this->handleAction('@SimplyTestableWebsite/Page/roadmap.html.twig');
    }

    /**
     * @param PlansService $plansService
     *
     * @return Response
     */
    public function accountBenefitsAction(PlansService $plansService)
    {
        return $this->handleAction(
            '@SimplyTestableWebsite/Page/accountbenefits.html.twig',
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
        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

        return $this->renderCacheableResponse($view, $additionalParameters);
    }
}
