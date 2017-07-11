<?php

namespace Tests\WebsiteBundle\Utility;

use Symfony\Component\Yaml\Yaml;

class ConfigResourceLoader
{
    const BUNDLE_RESOURCE_CONFIG_PATH = '/../../../src/SimplyTestable/WebsiteBundle/Resources/config';

    /**
     * @param string $relativePath
     *
     * @return mixed
     */
    public static function load($relativePath)
    {
        $resourcePath = realpath(__DIR__ . self::BUNDLE_RESOURCE_CONFIG_PATH . $relativePath);

        if (false === $resourcePath) {
            throw new \InvalidArgumentException(
                sprintf('Invalid fixture path %s', $relativePath)
            );
        }

        return Yaml::parse(file_get_contents($resourcePath));
    }
}
