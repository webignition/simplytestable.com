<?php

namespace SimplyTestable\WebsiteBundle\EventListener;

use Psr\Log\LoggerInterface;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable as CacheableController;
use SimplyTestable\WebsiteBundle\Model\CacheValidatorIdentifier;
use SimplyTestable\WebsiteBundle\Services\CacheableResponseFactory;
use SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class CachedResponseEventListener
{
    const REQUEST_HEADER_ETAG = 'x-cache-validator-etag';
    const REQUEST_HEADER_LASTMODIFIED = 'x-cache-validator-lastmodified';

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var CacheValidatorHeadersService
     */
    private $cacheValidatorHeadersService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CacheableController
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $cacheableControllers;

    /**
     * @param UserService $userService
     * @param CacheValidatorHeadersService $cacheValidatorHeadersService
     * @param LoggerInterface $logger
     * @param string[] $cacheableControllers
     */
    public function __construct(
        UserService $userService,
        CacheValidatorHeadersService $cacheValidatorHeadersService,
        LoggerInterface $logger,
        $cacheableControllers
    ) {
        $this->userService = $userService;
        $this->cacheValidatorHeadersService = $cacheValidatorHeadersService;
        $this->logger = $logger;
        $this->cacheableControllers = $cacheableControllers;
    }

    /**
     * @param FilterControllerEvent $event
     *
     * @return null
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return null;
        }

        $this->request = $event->getRequest();
        $controllerCallable = $event->getController();
        $this->controller = $controllerCallable[0];
        $this->action = $controllerCallable[1];

        if ($this->controller instanceof CacheableController) {
            $this->controller->setRequest($this->request);
            $this->setCacheValidatorHeadersOnRequest();

            $response = CacheableResponseFactory::createCacheableResponse($this->request);

            $this->fixRequestIfNoneMatchHeader();
            if ($response->isNotModified($this->request)) {
                $this->controller->setResponse($response);
            }
        }

        return null;
    }

    private function setCacheValidatorHeadersOnRequest()
    {
        $cacheValidatorHeaders = $this->cacheValidatorHeadersService->get(
            $this->createCacheValidatorIdentifier()
        );

        $this->request->headers->set(self::REQUEST_HEADER_ETAG, $cacheValidatorHeaders->getETag());
        $this->request->headers->set(
            self::REQUEST_HEADER_LASTMODIFIED,
            $cacheValidatorHeaders->getLastModifiedDate()->format('c')
        );
    }

    /**
     * @return CacheValidatorIdentifier
     */
    private function createCacheValidatorIdentifier()
    {
        $parameters = $this->controller->getCacheValidatorParameters($this->action);

        if ($this->request->headers->has('accept')) {
            $parameters['http-header-accept'] = $this->request->headers->get('accept');
        }

        $identifier = new CacheValidatorIdentifier();
        $identifier->setParameters(array_merge(
            [
                'route' => $this->request->get('_route'),
                'user' => $this->userService->getUser()->getUsername(),
                'is_logged_in' => $this->userService->isLoggedIn(),
            ],
            $parameters
        ));

        return $identifier;
    }

    private function fixRequestIfNoneMatchHeader()
    {
        $currentIfNoneMatch = $this->request->headers->get('if-none-match');

        $modifiedEtag = preg_replace('/-gzip"$/', '"', $currentIfNoneMatch);

        $this->request->headers->set('if-none-match', $modifiedEtag);
    }
}
