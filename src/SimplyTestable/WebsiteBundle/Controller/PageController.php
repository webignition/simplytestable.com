<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\PlanFeaturesService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PageController extends CacheableController
{
    /**
     * @return Response
     */
    public function plansAction()
    {
        return $this->handleAction([
            'prices' => $this->container->getParameter('plans')['pricing'],
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
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
     * @return Response
     */
    public function accountBenefitsAction()
    {
        return $this->handleAction([
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
        ]);
    }

    /**
     * @return PlanFeaturesService
     */
    private function getPlanFeaturesService()
    {
        return $this->container->get('simplytestable.services.planfeaturesservice');
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
