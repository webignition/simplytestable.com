<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\PlanFeaturesService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PlanDetailsController extends CacheableController
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
        'premium'
    );

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     *
     * @return RedirectResponse|Response
     */
    public function indexAction($name)
    {
        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

        $this->name = $name;

        if (!$this->isAllowedPlanName()) {
            return $this->redirect($this->generateUrl('page_plans'));
        }

        return $this->renderCacheableResponse(array(
            'prices' => $this->container->getParameter('plans')['pricing'],
            'features' => $this->getPlanFeaturesService()->getPlanFeatures()[$this->name],
            'plan' => $this->name
        ));
    }

    /**
     * @return string
     */
    protected function getViewFilename()
    {
        return str_replace('index.', 'index.' . $this->name . '.', parent::getViewFilename());
    }

    /**
     * @return boolean
     */
    private function isAllowedPlanName()
    {
        return in_array($this->name, $this->allowedPlanNames);
    }

    /**
     * @return PlanFeaturesService
     */
    private function getPlanFeaturesService()
    {
        return $this->container->get('simplytestable.services.planFeaturesService');
    }
}
