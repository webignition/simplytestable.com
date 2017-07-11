<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Services\CacheableResponseFactory;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use SimplyTestable\WebsiteBundle\Services\UserAgentDetector;
use SimplyTestable\WebsiteBundle\Services\UserService;
use SimplyTestable\WebsiteBundle\Services\WebClientRouter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractBaseController extends AbstractController
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var UserAgentDetector
     */
    private $userAgentDetector;

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
     * @param RequestStack $requestStack
     * @param UserAgentDetector $userAgentDetector
     * @param TestimonialService $testimonialService
     * @param UserService $userService
     * @param WebClientRouter $webClientRouter
     */
    public function __construct(
        RequestStack $requestStack,
        UserAgentDetector $userAgentDetector,
        TestimonialService $testimonialService,
        UserService $userService,
        WebClientRouter $webClientRouter
    ) {
        $this->requestStack = $requestStack;
        $this->userAgentDetector = $userAgentDetector;
        $this->testimonialService = $testimonialService;
        $this->userService = $userService;
        $this->webClientRouter = $webClientRouter;
    }

    /**
     * @return array
     */
    protected function getDefaultViewParameters()
    {
        return array(
            'testimonial' => $this->testimonialService->getRandom(),
            'user' => $this->userService->getUser(),
            'is_logged_in' => $this->userService->isLoggedIn(),
            'web_client_urls' => $this->webClientRouter->generateAll(),
        );
    }

    /**
     * @param array $additionalParameters
     *
     * @return Response
     */
    protected function renderResponse(array $additionalParameters = array())
    {
        return parent::render(
            $this->getViewName(),
            array_merge($this->getDefaultViewParameters(), $additionalParameters)
        );
    }

    /**
     * @param array $additionalParameters
     *
     * @return Response
     */
    protected function renderCacheableResponse(array $additionalParameters = array())
    {
        return CacheableResponseFactory::createCacheableResponse(
            $this->requestStack->getCurrentRequest(),
            $this->renderResponse($additionalParameters)
        );
    }

    /**
     * @return string
     */
    protected function getViewName()
    {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $bundleNamespaceParts = array_slice($classNamespaceParts, 0, array_search('Controller', $classNamespaceParts));

        return implode('', $bundleNamespaceParts) . ':' .  $this->getViewPath() . ':' . $this->getViewFilename();
    }

    /**
     * @return string
     */
    protected function getViewPath()
    {
        $classNamespaceParts = $this->getClassNamespaceParts();
        $controllerClassNameParts = array_slice(
            $classNamespaceParts,
            array_search('Controller', $classNamespaceParts) + 1
        );

        array_walk($controllerClassNameParts, function (&$part) {
            $part = preg_replace('/Controller$/', '', $part);
        });

        return implode('/', $controllerClassNameParts);
    }

    /**
     * @return string
     */
    protected function getViewFilename()
    {
        $routeParts = explode('_', $this->requestStack->getCurrentRequest()->get('_route'));

        return $routeParts[count($routeParts) - 1] . '.html.twig';
    }

    /**
     * @return string[]
     */
    private function getClassNamespaceParts()
    {
        return explode('\\', get_class($this));
    }

    /**
     * @return bool
     */
    protected function isOldIE()
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $this->userAgentDetector->setUserAgentString($currentRequest->headers->get('user-agent'));

        return $this->userAgentDetector->isOldIE();
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectToOutdatedBrowserResponse()
    {
        return $this->redirect($this->generateUrl('outdatedbrowser_index'));
    }
}
