<?php

namespace Tests\AppBundle\Utility;

use Symfony\Component\Yaml\Yaml;

class ConfigParameterResourceLoader
{
    const BUNDLE_RESOURCE_CONFIG_PATH = '/../../../config/parameters';

    /**
     * @param string $relativePath
     * @param string $key
     *
     * @return mixed
     */
    public static function load($relativePath, $key)
    {
        $resourcePath = realpath(__DIR__ . self::BUNDLE_RESOURCE_CONFIG_PATH . $relativePath);

        if (false === $resourcePath) {
            throw new \InvalidArgumentException(
                sprintf('Invalid fixture path %s', $relativePath)
            );
        }

        $parameters = Yaml::parse(file_get_contents($resourcePath));

        return $parameters['parameters'][$key];
    }
}
