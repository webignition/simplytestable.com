<?php

namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\Plan\Plan;
use SimplyTestable\WebsiteBundle\Model\Plan\PlanInterface;
use SimplyTestable\WebsiteBundle\Model\Plan\PseudoPlan;

class PlansService
{
    const PLAN_KEY_NAME = 'name';
    const PLAN_KEY_SHORT_TITLE = 'short_title';
    const PLAN_KEY_LONG_TITLE = 'long_title';
    const PLAN_KEY_SUB_TITLE = 'sub_title';
    const PLAN_KEY_PLAN_IDS = 'plan_ids';
    const PLAN_KEY_PRICE = 'price';
    const PLAN_KEY_IS_LISTED = 'is_listed';
    const PLAN_KEY_DISTINCTIONS = 'distinctions';

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
            $name = isset($planData[self::PLAN_KEY_NAME])
                ? $planData[self::PLAN_KEY_NAME]
                : '';

            $shortTitle = isset($planData[self::PLAN_KEY_SHORT_TITLE])
                ? $planData[self::PLAN_KEY_SHORT_TITLE]
                : '';

            $longTitle = isset($planData[self::PLAN_KEY_LONG_TITLE])
                ? $planData[self::PLAN_KEY_LONG_TITLE]
                : '';

            $subTitle = isset($planData[self::PLAN_KEY_SUB_TITLE])
                ? $planData[self::PLAN_KEY_SUB_TITLE]
                : '';

            if (isset($planData[self::PLAN_KEY_PLAN_IDS])) {
                $plans = [];

                foreach ($planData[self::PLAN_KEY_PLAN_IDS] as $existingPlanId) {
                    $plans[] = $this->plans[$existingPlanId];
                }

                $this->plans[$planId] = new PseudoPlan(
                    $planId,
                    $plans
                );
            } else {
                $this->plans[$planId] = new Plan(
                    $planId,
                    $planData[self::PLAN_KEY_PRICE],
                    $planData[self::PLAN_KEY_IS_LISTED],
                    $name,
                    $shortTitle,
                    $longTitle,
                    $subTitle,
                    $planData[self::PLAN_KEY_DISTINCTIONS]
                );
            }
        }

        $this->distinctions = $distinctionsData;
    }

    /**
     * @param $name
     * @return null|PlanInterface
     */
    public function getPlan($name)
    {
        return isset($this->plans[$name])
            ? $this->plans[$name]
            : null;
    }

    /**
     * @param string[] $planIds
     *
     * @return PlanInterface[]
     */
    public function getPlans($planIds = [])
    {
        $plans = $this->plans;

        if (!empty($planIds)) {
            $filteredPlans = [];

            foreach ($plans as $plan) {
                /* @var PlanInterface $plan */
                if (in_array($plan->getId(), $planIds)) {
                    $filteredPlans[$plan->getId()] = $plan;
                }
            }

            $plans = $filteredPlans;
        }

        return $plans;
    }

    /**
     * @return array
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }
}
