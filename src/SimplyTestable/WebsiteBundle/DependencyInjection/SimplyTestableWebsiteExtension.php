<?php

namespace SimplyTestable\WebsiteBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SimplyTestableWebsiteExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $planDataFileLocator = new FileLocator(__DIR__.'/../Resources/config/plans');
        $planData = Yaml::parse(file_get_contents($planDataFileLocator->locate('plans.yml')));
        $planDistinctionData = Yaml::parse(file_get_contents($planDataFileLocator->locate('distinctions.yml')));

        $container->setParameter('plans', $planData);
        $container->setParameter(('plan_distinctions'), $planDistinctionData);
    }
}
