<?php
namespace AppBundle\Services;

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
        $normalisedRequestUrl = $this->createNormalisedRequestUri($requestUri);

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
     *
     * @return string
     */
    private function createNormalisedRequestUri($requestUri)
    {
        if (preg_match('/^\/app_dev.php/', $requestUri) > 0) {
            $requestUri = preg_replace('/^\/app_dev.php/', '', $requestUri);
        }

        if (substr($requestUri, strlen($requestUri) - 1) === '/') {
            $requestUri = substr($requestUri, 0, strlen($requestUri) - 1);
        }

        return $requestUri;
    }
}
