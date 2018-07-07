<?php

namespace AppBundle\Model\Plan;

class Distinction implements DistinctionInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $id
     * @param int $value
     */
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
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
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isInt()
    {
        return is_int($this->value) || ctype_digit($this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function isInfinity()
    {
        return $this->value === INF;
    }

    /**
     * {@inheritdoc}
     */
    public function isBool()
    {
        return is_bool($this->value);
    }
}
