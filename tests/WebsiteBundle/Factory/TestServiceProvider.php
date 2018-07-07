<?php

namespace Tests\WebsiteBundle\Factory;

use SimplyTestable\WebsiteBundle\EventListener\CachedResponseEventListener;
use SimplyTestable\WebsiteBundle\EventListener\UserEventListener;
use SimplyTestable\WebsiteBundle\Services\ApplicationConfigurationService;
use SimplyTestable\WebsiteBundle\Services\NotFoundRedirectService;
use SimplyTestable\WebsiteBundle\Services\PlansService;
use SimplyTestable\WebsiteBundle\Services\ResourceLocator;
use SimplyTestable\WebsiteBundle\Services\UserService;
use SimplyTestable\WebsiteBundle\Services\WebClientRouter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use webignition\SimplyTestableUserSerializer\UserSerializer;

class TestServiceProvider
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return PlansService
     */
    public function getPlansService()
    {
        /* @var PlansService $service */
        $service = $this->container->get($this->createServiceNameFromServiceClass(PlansService::class));

        return $service;
    }

    /**
     * @return NotFoundRedirectService
     */
    public function getNotFoundRedirectService()
    {
        /* @var NotFoundRedirectService $service */
        $service = $this->container->get($this->createServiceNameFromServiceClass(NotFoundRedirectService::class));

        return $service;
    }

    /**
     * @return ApplicationConfigurationService
     */
    public function getApplicationConfigurationService()
    {
        /* @var ApplicationConfigurationService $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(ApplicationConfigurationService::class)
        );

        return $service;
    }

    /**
     * @return ResourceLocator
     */
    public function getResourceLocator()
    {
        /* @var ResourceLocator $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(ResourceLocator::class)
        );

        return $service;
    }

    /**
     * @return WebClientRouter
     */
    public function getWebClientRouter()
    {
        /* @var WebClientRouter $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(WebClientRouter::class)
        );

        return $service;
    }

    /**
     * @return CachedResponseEventListener
     */
    public function getCachedResponseEventListener()
    {
        /* @var CachedResponseEventListener $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(CachedResponseEventListener::class)
        );

        return $service;
    }

    /**
     * @return UserEventListener
     */
    public function getUserEventListener()
    {
        /* @var UserEventListener $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(UserEventListener::class)
        );

        return $service;
    }

    /**
     * @return UserSerializer
     */
    public function getUserSerializer()
    {
        /* @var UserSerializer $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(UserSerializer::class)
        );

        return $service;
    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        /* @var UserService $service */
        $service = $this->container->get(
            $this->createServiceNameFromServiceClass(UserService::class)
        );

        return $service;
    }

    /**
     * @param string $serviceClass
     *
     * @return string
     */
    private function createServiceNameFromServiceClass($serviceClass)
    {
        return 'test.' . strtolower($serviceClass);
    }
}
