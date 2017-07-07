<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

interface PlanInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string|int
     */
    public function getPrice();

    /**
     * @return array
     */
    public function getDistinctions();
}
