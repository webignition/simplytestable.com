<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;
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
     * {@inheritdoc}
     */
    protected function render($view, array $parameters = array(), Response $response = null)
    {
        $defaultParameters = [
            'testimonial' => $this->testimonialService->getRandom(),
            'user' => $this->userService->getUser(),
            'is_logged_in' => $this->userService->isLoggedIn(),
            'web_client_urls' => $this->webClientRouter->generateAll(),
        ];

        $response = parent::render(
            $view,
            array_merge($defaultParameters, $parameters),
            $response
        );

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
