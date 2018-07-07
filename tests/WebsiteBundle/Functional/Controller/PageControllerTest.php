<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\PageController;
use SimplyTestable\WebsiteBundle\Services\PlansService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;

class PageControllerTest extends AbstractControllerTest
{
    /**
     * @var PageController
     */
    private $controller;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->controller = $this->container->get(PageController::class);
    }

    public function testPlansActionHasResponse()
    {
        $request = new Request();
        $this->container->get('request_stack')->push($request);

        $response = new Response();
        $this->controller->setResponse($response);

        $retrievedResponse = $this->controller->plansAction($this->testServiceProvider->getPlansService());

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testFeaturesActionHasResponse()
    {
        $request = new Request();
        $this->container->get('request_stack')->push($request);

        $response = new Response();
        $this->controller->setResponse($response);

        $retrievedResponse = $this->controller->featuresAction();

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testAccountBenefitsActionHasResponse()
    {
        $request = new Request();
        $this->container->get('request_stack')->push($request);

        $response = new Response();
        $this->controller->setResponse($response);

        $retrievedResponse = $this->controller->accountBenefitsAction($this->testServiceProvider->getPlansService());

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testPlansActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();
        $this->container->get('request_stack')->push($request);

        $response = $this->controller->plansAction($this->testServiceProvider->getPlansService());

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }

    public function testFeaturesActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();
        $this->container->get('request_stack')->push($request);

        $response = $this->controller->featuresAction();

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }

    public function testAccountBenefitsActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();
        $this->container->get('request_stack')->push($request);

        $response = $this->controller->accountBenefitsAction($this->testServiceProvider->getPlansService());

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
