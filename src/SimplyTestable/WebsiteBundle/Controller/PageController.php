<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered;
use SimplyTestable\WebsiteBundle\Services\PlanFeaturesService;
use Symfony\Component\HttpFoundation\Response;

class PageController extends CacheableController implements IEFiltered
{
    /**
     * @return Response
     */
    public function plansAction()
    {
        return $this->renderCacheableResponse(array(
            'prices' => $this->container->getParameter('plans')['pricing'],
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
        ));
    }

    /**
     * @return Response
     */
    public function featuresAction()
    {
        return $this->renderCacheableResponse();
    }

    /**
     * @return Response
     */
    public function roadmapAction()
    {
        return $this->renderCacheableResponse();
    }

    /**
     * @return Response
     */
    public function accountBenefitsAction()
    {
        return $this->renderCacheableResponse(array(
            'plan_features' => $this->getPlanFeaturesService()->getPlanFeatures()
        ));
    }

    /**
     * @return PlanFeaturesService
     */
    private function getPlanFeaturesService()
    {
        return $this->container->get('simplytestable.services.planFeaturesService');
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
}
