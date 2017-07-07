<?php

namespace SimplyTestable\WebsiteBundle\Model\Plan;

class DistinctionDecorator implements DistinctionInterface
{
    const NUMBER_RANGE_SEPARATOR = '-';

    /**
     * @var DistinctionInterface
     */
    private $distinction;

    /**
     * @param DistinctionInterface $distinction
     */
    public function __construct(DistinctionInterface $distinction)
    {
        $this->distinction = $distinction;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->distinction->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->distinction->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $value = $this->getValue();

        if (gettype($value) === 'integer') {
            return number_format($value);
        }

        if (gettype($value) === 'string' && $this->isNumberRange($value)) {
            return $this->numberFormatRangeString($value);
        }

        return (string)$value;
    }

    /**
     * @param $value
     * @return bool
     */
    private function isNumberRange($value)
    {
        return preg_match('/[0-9]+\s' . self::NUMBER_RANGE_SEPARATOR . '\s[0-9]+/', $value) > 0;
    }

    /**
     * @param $rangeString
     *
     * @return string
     */
    private function numberFormatRangeString($rangeString)
    {
        $parts = array_map(
            'trim',
            explode(self::NUMBER_RANGE_SEPARATOR, $rangeString)
        );

        foreach ($parts as $index => $part) {
            $parts[$index] = number_format($part);
        }

        return implode($parts, ' ' . self::NUMBER_RANGE_SEPARATOR . ' ');
    }
}
