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
     * @var bool
     */
    private $isListed;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortTitle;

    /**
     * @var string
     */
    private $longTitle;

    /**
     * @var string
     */
    private $subTitle;

    /**
     * @var array
     */
    private $distinctions = [];

    /**
     * @param string $id
     * @param int $price
     * @param bool $isListed
     * @param string $name
     * @param string $shortTitle
     * @param string $longTitle
     * @param string $subTitle
     * @param array $distinctions
     */
    public function __construct($id, $price, $isListed, $name, $shortTitle, $longTitle, $subTitle, $distinctions)
    {
        $this->id = $id;
        $this->price = $price;
        $this->isListed = $isListed;
        $this->name = $name;
        $this->shortTitle = $shortTitle;
        $this->longTitle = $longTitle;
        $this->subTitle = $subTitle;

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
    public function getIsListed()
    {
        return $this->isListed;
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
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongTitle()
    {
        return $this->longTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubtitle()
    {
        return $this->subTitle;
    }
}
