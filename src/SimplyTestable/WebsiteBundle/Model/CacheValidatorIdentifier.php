<?php

namespace SimplyTestable\WebsiteBundle\Model;

class CacheValidatorIdentifier
{
    /**
      * @var array
     */
    private $parameters = array();

    /**
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        foreach ($parameters as $key => $value) {
            $this->setParameter($key, $value);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setParameter($key, $value)
    {
        if (is_bool($value)) {
            $value = ($value) ? 'true' : 'false';
        }

        $this->parameters[$key] = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $keyValuePairs = array();
        foreach ($this->parameters as $key => $value) {
            $keyValuePairs[] = $key . ':' . $value;
        }

        return md5(implode('+', $keyValuePairs));
    }
}
