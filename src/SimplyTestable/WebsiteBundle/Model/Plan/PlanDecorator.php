<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

class PlanDecorator implements PlanInterface
{
    /**
     * @var PlanInterface
     */
    private $plan;

    /**
     * @var DistinctionInterface[]
     */
    private $distinctions;

    /**
     * @param PlanInterface $plan
     */
    public function __construct(PlanInterface $plan)
    {
        $this->plan = $plan;
        $distinctions = $plan->getDistinctions();

        $decoratedDistinctions = [];

//        var_dump($plan->getId());

        foreach ($distinctions as $groupName => $distinctionGroup) {
//            var_dump($groupName);

            $decoratedDistinctionGroup = [];

            foreach ($distinctionGroup as $distinctionId => $distinction) {
//                var_dump($distinctionId);

                $decoratedDistinctionGroup[$distinctionId] = new DistinctionDecorator($distinction);
            }
//
            $decoratedDistinctions[$groupName] = $decoratedDistinctionGroup;
        }

//        exit();

        $this->distinctions = $decoratedDistinctions;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->plan->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return '£' . $this->plan->getPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }
}
