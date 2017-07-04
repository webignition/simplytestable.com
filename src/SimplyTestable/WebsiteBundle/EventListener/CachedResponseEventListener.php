<?php

namespace SimplyTestable\WebsiteBundle\EventListener;

use Psr\Log\LoggerInterface;
use SimplyTestable\WebsiteBundle\Services\CacheableResponseFactory;
use SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable as CacheableController;
use SimplyTestable\WebsiteBundle\Model\CacheValidatorIdentifier;

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
     * @var Request
     */
    private $request;

    /**
     * @param UserService $userService
     * @param CacheValidatorHeadersService $cacheValidatorHeadersService
     * @param LoggerInterface $logger
     */
    public function __construct(
        UserService $userService,
        CacheValidatorHeadersService $cacheValidatorHeadersService,
        LoggerInterface $logger
    ) {
        $this->userService = $userService;
        $this->cacheValidatorHeadersService = $cacheValidatorHeadersService;
        $this->logger = $logger;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return null
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $this->request = $event->getRequest();
        $this->controller = $this->createController();

        if (empty($this->controller)) {
            return null;
        }

        if ($this->controller instanceof CacheableController) {
            $this->controller->setRequest($this->request);
            $this->setCacheValidatorHeadersOnRequest();

            $response = CacheableResponseFactory::createCacheableResponse($this->request);

            $this->fixRequestIfNoneMatchHeader();
            if ($response->isNotModified($this->request)) {
                $event->setResponse($response);
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
        $parameters = $this->controller->getCacheValidatorParameters($this->getActionName());

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

    /**
     * @return string
     */
    private function getControllerClassName()
    {
        return $this->getControllerActionParts()[0];
    }

    /**
     * @return string
     */
    private function getActionName()
    {
        return $this->getControllerActionParts()[1];
    }

    /**
     * @return array
     */
    private function getControllerActionParts()
    {
        return explode('::', $this->request->attributes->get('_controller'));
    }

    /**
     * @return Controller|null
     */
    private function createController()
    {
        $className = $this->getControllerClassName();

        return class_exists($className)
            ? new $className
            : null;
    }
}
