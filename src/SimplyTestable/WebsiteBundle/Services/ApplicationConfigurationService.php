<?php
namespace SimplyTestable\WebsiteBundle\Services;

class ApplicationConfigurationService
{
    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $rootDir
     * @param string $cacheDir
     */
    public function __construct($rootDir, $cacheDir)
    {
        $this->rootDir = $rootDir;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @return string
     */
    public function getWebDir()
    {
        return realpath($this->getRootDir() . '/../web');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return realpath($this->cacheDir);
    }
}
