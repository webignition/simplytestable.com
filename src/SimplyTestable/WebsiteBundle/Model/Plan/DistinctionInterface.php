<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

interface DistinctionInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return int
     */
    public function getValue();
}
