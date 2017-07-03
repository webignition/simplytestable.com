<?php
namespace SimplyTestable\WebsiteBundle\Factory;

use Symfony\Bundle\AsseticBundle\Factory\AssetFactory as BaseAssetFactory;
use Assetic\Factory\Worker\CacheBustingWorker;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class AssetFactory extends BaseAssetFactory
{
    /**
     * @param KernelInterface $kernel
     * @param ContainerInterface $container
     * @param ParameterBagInterface $parameterBag
     * @param string $baseDir
     * @param bool $debug
     */
    public function __construct(
        KernelInterface $kernel,
        ContainerInterface $container,
        ParameterBagInterface $parameterBag,
        $baseDir,
        $debug = false
    ) {
        parent::__construct($kernel, $container, $parameterBag, $baseDir, $debug);
        $this->addWorker(new CacheBustingWorker());
    }
}
