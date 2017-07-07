<?php

namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\Plan\Plan;
use SimplyTestable\WebsiteBundle\Model\Plan\PlanInterface;
use SimplyTestable\WebsiteBundle\Model\Plan\PseudoPlan;

class PlansService
{
    /**
     * @var PlanInterface[]
     */
    private $plans = [];

    /**
     * @var array
     */
    private $distinctions;

    /**
     * @param array $plansData
     * @param array $distinctionsData
     */
    public function __construct($plansData, $distinctionsData)
    {
        foreach ($plansData as $planId => $planData) {
            if ($planData['is_pseudo_plan']) {
                $plans = [];

                foreach ($planData['planIds'] as $existingPlanId) {
                    $plans[] = $this->plans[$existingPlanId];
                }

                $this->plans[$planId] = new PseudoPlan(
                    $planId,
                    $plans
                );
            } else {
                $this->plans[$planId] = new Plan(
                    $planId,
                    $planData['price'],
                    $planData['distinctions']
                );
            }
        }

        $this->distinctions = $distinctionsData;
    }

    /**
     * @return PlanInterface[]
     */
    public function getPlans()
    {

        return $this->plans;
    }

    /**
     * @return array
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }
}
