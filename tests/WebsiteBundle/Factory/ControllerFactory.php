<?php

namespace Tests\WebsiteBundle\Factory;

use SimplyTestable\WebsiteBundle\Controller\AbstractBaseController;
use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\Controller\LandingPageController;
use SimplyTestable\WebsiteBundle\Controller\OutdatedBrowserController;
use SimplyTestable\WebsiteBundle\Controller\PageController;
use SimplyTestable\WebsiteBundle\Controller\PlanDetailsController;
use SimplyTestable\WebsiteBundle\Services\TestimonialService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use SimplyTestable\WebsiteBundle\Services\WebClientRouter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerFactory
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
     * @param Request $request
     *
     * @return HomeController
     */
    public function createHomeController(Request $request)
    {
        /* @var HomeController $homeController */
        $homeController = $this->createController($request, HomeController::class);

        return $homeController;
    }

    /**
     * @param Request $request
     *
     * @return LandingPageController
     */
    public function createLandingPageController(Request $request)
    {
        /* @var LandingPageController $landingPageController */
        $landingPageController = $this->createController($request, LandingPageController::class);

        return $landingPageController;
    }

    /**
     * @param Request $request
     *
     * @return PlanDetailsController
     */
    public function createPlanDetailsController(Request $request)
    {
        /* @var PlanDetailsController $planDetailsController */
        $planDetailsController = $this->createController($request, PlanDetailsController::class);

        return $planDetailsController;
    }

    /**
     * @param Request $request
     *
     * @return OutdatedBrowserController
     */
    public function createOutdatedBrowserController(Request $request)
    {
        /* @var OutdatedBrowserController $outdatedBrowserController */
        $outdatedBrowserController = $this->createController($request, OutdatedBrowserController::class);

        return $outdatedBrowserController;
    }

    /**
     * @param Request $request
     *
     * @return PageController
     */
    public function createPageController(Request $request)
    {
        /* @var PageController $pageController */
        $pageController = $this->createController($request, PageController::class);

        return $pageController;
    }

    /**
     * @param Request $request
     * @param string $className
     *
     * @return AbstractBaseController
     */
    private function createController(Request $request, $className)
    {
        $requestStack = $this->container->get('request_stack');
        $requestStack->push($request);

        $controller = new $className(
            $requestStack,
            $this->container->get(TestimonialService::class),
            $this->container->get(UserService::class),
            $this->container->get(WebClientRouter::class),
            $this->container->get('twig'),
            $this->container->get('router')
        );

        return $controller;
    }
}
