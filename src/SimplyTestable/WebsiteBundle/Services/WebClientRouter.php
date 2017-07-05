<?php
namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class WebClientRouter
{
    const BUNDLE_CONFIG_PATH = '@SimplyTestableWebsiteBundle/Resources/config';
    const ROUTING_RESOURCE = 'webclientrouting.yml';
    const URL_PLACEHOLDER = '{{url}}';

    const ROUTE_NAME_START_TEST = 'start_test';
    const ROUTE_NAME_SIGN_IN = 'sign_in';
    const ROUTE_NAME_SIGN_UP = 'sign_up';
    const ROUTE_NAME_ACCOUNT = 'account';
    const ROUTE_NAME_PLAN_SUBSCRIBE = 'plan_subscribe';
    const ROUTE_NAME_HISTORY = 'history';

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $encodedUrlPlaceholder = null;

    /**
     * @param string $baseUrl
     * @param KernelInterface $kernel
     * @param string $cachePath
     */
    public function __construct($baseUrl, KernelInterface $kernel, $cachePath)
    {
        $this->baseUrl = $baseUrl;

        $locator = new FileLocator([$kernel->locateResource(self::BUNDLE_CONFIG_PATH)]);
        $requestContext = new RequestContext();
        $requestContext->fromRequest(Request::createFromGlobals());

        $this->router = new Router(
            new YamlFileLoader($locator),
            self::ROUTING_RESOURCE,
            ['cache_dir' => $cachePath],
            $requestContext
        );

        $this->encodedUrlPlaceholder = rawurlencode(self::URL_PLACEHOLDER);
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
            $urls[$routeName] = $this->baseUrl . $this->router->generate($routeName);
        }

        return $urls;
    }
}
