<?php

namespace App\Services;

use App\Model\Plan\PlanDecorator;
use App\Model\Plan\PlanInterface;

class DecoratedPlanFactory
{
    /**
     * @param PlanInterface $plan
     *
     * @return PlanDecorator
     */
    public static function decorate(PlanInterface $plan)
    {
        $decoratedPlan = new PlanDecorator($plan);

        return $decoratedPlan;
    }

    /**
     * @param PlanInterface[] $plans
     *
     * @return PlanDecorator[]
     */
    public static function decorateCollection($plans)
    {
        $decoratedPlans = [];

        foreach ($plans as $plan) {
            $decoratedPlans[$plan->getId()] = static::decorate($plan);
        }

        return $decoratedPlans;
    }
}
