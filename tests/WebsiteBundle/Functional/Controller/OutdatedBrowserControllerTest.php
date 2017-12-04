<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class OutdatedBrowserControllerTest extends AbstractWebTestCase
{
    public function testIndexAction()
    {
        $this->client->request('GET', '/outdated-browser/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testIndexActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createOutdatedBrowserController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->indexAction();

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }
}
