<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

class Plan implements PlanInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $price;

    /**
     * @var array
     */
    private $distinctions = [];

    /**
     * @param string $id
     * @param int $price
     * @param array $distinctions
     */
    public function __construct($id, $price, $distinctions)
    {
        $this->id = $id;
        $this->price = $price;

        foreach ($distinctions as $group => $groupDistinctionData) {
            $groupDistinctions = [];
            foreach ($groupDistinctionData as $distinctionId => $distinctionValue) {
                $groupDistinctions[$distinctionId] = new Distinction($distinctionId, $distinctionValue);
            }

            $this->distinctions[$group] = $groupDistinctions;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getDistinctions()
    {
        return $this->distinctions;
    }
}
