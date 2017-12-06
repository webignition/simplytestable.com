<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Services\PlansService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;

class PageControllerTest extends AbstractControllerTest
{
    public function testPlansActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->plansAction(
            $this->container->get(PlansService::class)
        );

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testFeaturesActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->featuresAction();

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testAccountBenefitsActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->accountBenefitsAction(
            $this->container->get(PlansService::class)
        );

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testPlansActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);

        $response = $controller->plansAction(
            $this->container->get(PlansService::class)
        );

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }

    public function testFeaturesActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);

        $response = $controller->featuresAction();

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }

    public function testAccountBenefitsActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPageController($request);

        $response = $controller->accountBenefitsAction(
            $this->container->get(PlansService::class)
        );

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
