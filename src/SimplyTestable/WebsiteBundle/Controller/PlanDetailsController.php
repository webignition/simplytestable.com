<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\DecoratedPlanFactory;
use SimplyTestable\WebsiteBundle\Services\PlansService;
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
        'premium',
    );

    /**
     * @var string
     */
    private $name;

    /**
     * @param PlansService $plansService
     * @param string $name
     *
     * @return RedirectResponse|Response
     */
    public function indexAction(PlansService $plansService, $name)
    {
        if ($this->hasResponse()) {
            return $this->getResponse();
        }

        if ($this->isOldIE()) {
            return $this->createRedirectToOutdatedBrowserResponse();
        }

        $name = strtolower($name);

        $isAllowedPlanName = in_array($name, $this->allowedPlanNames);
        if (!$isAllowedPlanName) {
            return $this->redirect('page_plans');
        }

        if ($name == 'premium') {
            return $this->redirect('plandetails_index', [
                'name' => 'agency',
            ]);
        }

        $this->name = $name;

        $plans = DecoratedPlanFactory::decorateCollection($plansService->getPlans($this->allowedPlanNames));
        $plan = $plans[$name];

        return $this->render(
            '@SimplyTestableWebsite/PlanDetails/' . $name . '.html.twig',
            [
                'plans' => $plans,
                'plan' => $plan,
                'distinctions' => $plansService->getDistinctions(),
            ]
        );
    }
}
