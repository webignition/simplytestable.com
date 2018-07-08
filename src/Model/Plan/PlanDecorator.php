<?php

namespace App\Model\Plan;

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
        foreach ($distinctions as $groupName => $distinctionGroup) {
            $decoratedDistinctionGroup = [];

            foreach ($distinctionGroup as $distinctionId => $distinction) {
                $decoratedDistinctionGroup[$distinctionId] = new DistinctionDecorator($distinction);
            }

            $decoratedDistinctions[$groupName] = $decoratedDistinctionGroup;
        }

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
        return '&pound;' . $this->plan->getPrice();
    }

    /**
     * {@inheritdoc}
     */
    public function getIsListed()
    {
        return $this->plan->getIsListed();
    }

    /**
     * {@inheritdoc}
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->plan->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getShortTitle()
    {
        return $this->plan->getShortTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getLongTitle()
    {
        return $this->plan->getLongTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubtitle()
    {
        return $this->plan->getSubtitle();
    }
}
