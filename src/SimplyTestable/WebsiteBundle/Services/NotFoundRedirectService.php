<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class NotFoundRedirectService
{
    /**
     * @var array
     */
    private $notFoundRedirectMap = [];

    /**
     * @var string
     */
    private $normalisedRequestUri = '';

    /**
     * @var string
     */
    private $localBaseUrl;

    /**
     * @var RouterInterface
     */
    private $routers = [];

    /**
     * @param array $notFoundRedirectMap
     * @param string $localBaseUrl
     */
    public function __construct($notFoundRedirectMap, $localBaseUrl)
    {
        $this->notFoundRedirectMap = $notFoundRedirectMap;
        $this->localBaseUrl = $localBaseUrl;
    }

    /**
     * @param string $groupName
     * @param RouterInterface $router
     */
    public function addRouter($groupName, RouterInterface $router)
    {
        if ($groupName == 'local') {
            $router = clone $router;
            $router->getContext()->setBaseUrl($this->localBaseUrl);
        }

        $this->routers[$groupName] = $router;
    }

    /**
     * @param string $requestUri
     *
     * @return string|null
     */
    public function getRedirectFor($requestUri)
    {
        $this->setNormalisedRequestUri($requestUri);
        $normalisedRequestUrl = $this->getNormalisedRequestUri();

        if (!isset($this->notFoundRedirectMap[$normalisedRequestUrl])) {
            return null;
        }

        $redirectProperties = $this->notFoundRedirectMap[$normalisedRequestUrl];

        if (!isset($this->routers[$redirectProperties['group']])) {
            return null;
        }

        /* @var RouterInterface $router */
        $router = $this->routers[$redirectProperties['group']];
        $route = $redirectProperties['route'];

        return $router->generate($route, []);
    }

    /**
     * @param string $requestUri
     */
    private function setNormalisedRequestUri($requestUri)
    {
        if (preg_match('/^\/app_dev.php/', $requestUri) > 0) {
            $requestUri = preg_replace('/^\/app_dev.php/', '', $requestUri);
        }

        if (substr($requestUri, strlen($requestUri) - 1) === '/') {
            $requestUri = substr($requestUri, 0, strlen($requestUri) - 1);
        }

        $this->normalisedRequestUri = $requestUri;
    }

    /**
     * @return string
     */
    private function getNormalisedRequestUri()
    {
        return $this->normalisedRequestUri;
    }
}
