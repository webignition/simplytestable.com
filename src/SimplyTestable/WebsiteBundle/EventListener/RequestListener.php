<?php

namespace SimplyTestable\WebsiteBundle\EventListener;

use SimplyTestable\WebsiteBundle\Services\CacheValidatorHeadersService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable as CacheableController;
use SimplyTestable\WebsiteBundle\Interfaces\Controller\IEFiltered as IEFilteredController;
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

        if ($this->isIeFilteredController() && $this->isUsingOldIE()) {
            $this->event->setResponse($this->getRedirectResponseToOutdatedBrowserPage());
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

    /**
     * @return RedirectResponse
     */
    private function getRedirectResponseToOutdatedBrowserPage()
    {
        return new RedirectResponse(
            $this->kernel->getContainer()->get('router')->generate('outdatedbrowser_index', array(), true)
        );
    }

    private function fixRequestIfNoneMatchHeader()
    {
        $currentIfNoneMatch = $this->event->getRequest()->headers->get('if-none-match');

        $modifiedEtag = preg_replace('/-gzip"$/', '"', $currentIfNoneMatch);

        $this->event->getRequest()->headers->set('if-none-match', $modifiedEtag);
    }

    /**
     * @return boolean
     */
    private function isIeFilteredController()
    {
        return $this->getController() instanceof IEFilteredController;
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
     * @return boolean
     */
    private function isUsingOldIE()
    {
        if ($this->isUsingIE6() || $this->isUsingIE7()) {
            $this->kernel->getContainer()->get('logger')
                ->err('Detected old IE for [' . $this->getUserAgentString() . ']');
            return true;
        }

        return false;
    }

    /**
     * @return boolean
     */
    private function isUsingIE6()
    {
        // // Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)

        if (!preg_match('/msie 6\.[0-9]+/i', $this->getUserAgentString())) {
            return false;
        }

        if (preg_match('/opera/i', $this->getUserAgentString())) {
            return false;
        }

        if (preg_match('/msie 8.[0-9]+/i', $this->getUserAgentString())) {
            return false;
        }

        return true;
    }

    /**
     * @return boolean
     */
    private function isUsingIE7()
    {
        if (!preg_match('/msie 7\.[0-9]+/i', $this->getUserAgentString())) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    private function getUserAgentString()
    {
        return $this->event->getRequest()->server->get('HTTP_USER_AGENT');
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
