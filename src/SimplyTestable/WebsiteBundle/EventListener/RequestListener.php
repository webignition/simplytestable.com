<?php

namespace SimplyTestable\WebsiteBundle\EventListener;

use SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable as CacheableController;
use SimplyTestable\WebsiteBundle\Model\CacheValidatorIdentifier;

class RequestListener
{
    const APPLICATION_CONTROLLER_PREFIX = 'SimplyTestable\WebsiteBundle\Controller\\';

    /**
     * @var GetResponseEvent
     */
    private $event;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @param Kernel $kernel
     */
    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return null
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->event = $event;

        if (!$this->isApplicationController()) {
            return;
        }

        $this->getUserService()->setUserFromRequest($this->event->getRequest());

        if (!$this->isCacheableController()) {
            return;
        }

        $this->setRequestCacheValidatorHeaders();

        $response = $this->getCacheableResponseService()->getCachableResponse($this->event->getRequest());

        $this->fixRequestIfNoneMatchHeader();
        if ($response->isNotModified($this->event->getRequest())) {
            $this->event->setResponse($response);
        }

        return null;
    }

    private function setRequestCacheValidatorHeaders()
    {
        /* @var $controller CacheableController */
        $controller = $this->getController();
        $controller->setRequest($this->event->getRequest());

        $cacheValidatorParameters = $controller->getCacheValidatorParameters($this->getActionName());

        if ($this->event->getRequest()->headers->has('accept')) {
            $cacheValidatorHeaders['http-header-accept'] = $this->event->getRequest()->headers->get('accept');
        }

        $cacheValidatorIdentifier = $this->getCacheValidatorIdentifier($cacheValidatorParameters);
        $cacheValidatorHeaders = $this->getCacheValidatorHeadersService()->get($cacheValidatorIdentifier);

        $this->event->getRequest()->headers->set('x-cache-validator-etag', $cacheValidatorHeaders->getETag());
        $this->event->getRequest()->headers->set(
            'x-cache-validator-lastmodified',
            $cacheValidatorHeaders->getLastModifiedDate()->format('c')
        );
    }

    private function fixRequestIfNoneMatchHeader()
    {
        $currentIfNoneMatch = $this->event->getRequest()->headers->get('if-none-match');

        $modifiedEtag = preg_replace('/-gzip"$/', '"', $currentIfNoneMatch);

        $this->event->getRequest()->headers->set('if-none-match', $modifiedEtag);
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
        return explode('::', $this->event->getRequest()->attributes->get('_controller'));
    }

    /**
     * @return boolean
     */
    private function isApplicationController()
    {
        return substr($this->getControllerClassName(), 0, strlen(self::APPLICATION_CONTROLLER_PREFIX))
            == self::APPLICATION_CONTROLLER_PREFIX;
    }

    /**
     * @return Controller
     */
    private function getController()
    {
        $className = $this->getControllerClassName();
        return new $className;
    }

    /**
     * @return boolean
     */
    private function isCacheableController()
    {
        return $this->getController() instanceof CacheableController;
    }

    /**
     * @return CacheValidatorHeadersService
     */
    private function getCacheValidatorHeadersService()
    {
        return $this->kernel->getContainer()->get('simplytestable.services.cachevalidatorheadersservice');
    }

    /**
     * @param array $parameters
     *
     * @return CacheValidatorIdentifier
     */
    private function getCacheValidatorIdentifier(array $parameters = array())
    {
        $identifier = new CacheValidatorIdentifier();
        $identifier->setParameter('route', $this->kernel->getContainer()->get('request')->get('_route'));
        $identifier->setParameter('user', $this->getUserService()->getUser()->getUsername());
        $identifier->setParameter('is_logged_in', $this->getUserService()->isLoggedIn());

        foreach ($parameters as $key => $value) {
            $identifier->setParameter($key, $value);
        }

        return $identifier;
    }

    /**
     * @return UserService
     */
    private function getUserService()
    {
        return $this->kernel->getContainer()->get('simplytestable.services.userservice');
    }

    /**
     * @return \SimplyTestable\WebsiteBundle\Services\CacheableResponseService
     */
    private function getCacheableResponseService()
    {
        return $this->kernel->getContainer()->get('simplytestable.services.cacheableResponseService');
    }
}
