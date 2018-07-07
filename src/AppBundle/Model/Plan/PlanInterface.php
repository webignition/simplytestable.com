<?php

namespace AppBundle\Model\Plan;

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
     * @return bool
     */
    public function getIsListed();

    /**
     * @return array
     */
    public function getDistinctions();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getShortTitle();

    /**
     * @return string
     */
    public function getLongTitle();

    /**
     * @return string
     */
    public function getSubtitle();
}
