<?php

namespace App\Cache;

use App\Services\WebClientRouter;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class WebClientRouterCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var ContainerInterface
     */
    private $webClientRouter;

    /**
     * @param WebClientRouter $webClientRouter
     */
    public function __construct(WebClientRouter $webClientRouter)
    {
        $this->webClientRouter = $webClientRouter;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return true;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $this->webClientRouter->warmUp($cacheDir);
    }
}
