<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\OutdatedBrowserController;
use Symfony\Component\HttpFoundation\Response;
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
        $response = new Response();

        $controller = $this->container->get(OutdatedBrowserController::class);
        $controller->setResponse($response);

        $retrievedResponse = $controller->indexAction();

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }
}
