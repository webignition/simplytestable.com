<?php
namespace SimplyTestable\WebsiteBundle\Services;

class ApplicationConfigurationService
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @param string $baseUrl
     * @param string $rootDir
     * @param string $cacheDir
     */
    public function __construct($baseUrl, $rootDir, $cacheDir)
    {
        $this->baseUrl = $baseUrl;
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

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
