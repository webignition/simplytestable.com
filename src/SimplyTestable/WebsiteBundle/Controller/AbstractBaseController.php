<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\CacheableResponseFactory;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use SimplyTestable\WebsiteBundle\Services\WebClientRouter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment as TwigEnvironment;
use webignition\IEDetector\IEDetector;

abstract class AbstractBaseController
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var WebClientRouter
     */
    private $webClientRouter;

    /**
     * @var TwigEnvironment
     */
    private $twig;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RequestStack $requestStack
     * @param TestimonialService $testimonialService
     * @param UserService $userService
     * @param WebClientRouter $webClientRouter
     * @param TwigEnvironment $twig
     * @param RouterInterface $router
     */
    public function __construct(
        RequestStack $requestStack,
        TestimonialService $testimonialService,
        UserService $userService,
        WebClientRouter $webClientRouter,
        TwigEnvironment $twig,
        RouterInterface $router
    ) {
        $this->requestStack = $requestStack;
        $this->testimonialService = $testimonialService;
        $this->userService = $userService;
        $this->webClientRouter = $webClientRouter;
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        $defaultParameters = [
            'testimonial' => $this->testimonialService->getRandom(),
            'user' => $this->userService->getUser(),
            'is_logged_in' => $this->userService->isLoggedIn(),
            'web_client_urls' => $this->webClientRouter->generateAll(),
        ];

        $content = $this->twig->render($view, array_merge($defaultParameters, $parameters));
        $response->setContent($content);

        if ($this instanceof CacheableController) {
            $response = CacheableResponseFactory::createCacheableResponse(
                $this->requestStack->getCurrentRequest(),
                $response
            );
        }

        return $response;
    }

    /**
     * @return bool
     */
    protected function isOldIE()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $userAgentString = $currentRequest->headers->get('user-agent');

        return IEDetector::isIE6($userAgentString) ||
            IEDetector::isIE7($userAgentString) ||
            IEDetector::isIE8($userAgentString) ||
            IEDetector::isIE9($userAgentString);
    }

    /**
     * @param string $routeName
     * @param array $parameters
     *
     * @return RedirectResponse
     */
    protected function redirect($routeName, $parameters = [])
    {
        $url = $this->router->generate(
            $routeName,
            $parameters,
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new RedirectResponse($url);
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectToOutdatedBrowserResponse()
    {
        return $this->redirect('outdatedbrowser_index');
    }
}
