<?php
namespace AppBundle\Services;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class WebClientRouter implements RouterInterface
{
    const ROUTING_RESOURCE = 'webclientrouting.yml';
    const ROUTE_NAME_START_TEST = 'start_test';
    const ROUTE_NAME_SIGN_IN = 'sign_in';
    const ROUTE_NAME_SIGN_UP = 'sign_up';
    const ROUTE_NAME_ACCOUNT = 'account';
    const ROUTE_NAME_PLAN_SUBSCRIBE = 'plan_subscribe';
    const ROUTE_NAME_HISTORY = 'history';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param string $baseUrl
     * @param string $kernelRootDirectory
     * @param string $kernelCacheDirectory
     */
    public function __construct($baseUrl, $kernelRootDirectory, $kernelCacheDirectory)
    {
        $locator = new FileLocator($kernelRootDirectory . '/config/config');

        $requestContext = new RequestContext();
        $requestContext->fromRequest(Request::createFromGlobals());

        $this->router = new Router(
            new YamlFileLoader($locator),
            self::ROUTING_RESOURCE,
            ['cache_dir' => $kernelCacheDirectory],
            $requestContext
        );

        $this->router->getContext()->setBaseUrl($baseUrl);
    }

    /**
     * @return string[]
     */
    public function generateAll()
    {
        $routeNames = [
            self::ROUTE_NAME_START_TEST,
            self::ROUTE_NAME_SIGN_IN,
            self::ROUTE_NAME_SIGN_UP,
            self::ROUTE_NAME_ACCOUNT,
            self::ROUTE_NAME_PLAN_SUBSCRIBE,
            self::ROUTE_NAME_HISTORY,
        ];

        $urls = [];

        foreach ($routeNames as $routeName) {
            $urls[$routeName] = $this->router->generate($routeName);
        }

        return $urls;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        $this->router->setContext($context);
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        return $this->router->getContext();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteCollection()
    {
        return $this->router->getRouteCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     * {@inheritdoc}
     */
    public function match($pathinfo)
    {
        return $this->match($pathinfo);
    }
}
