<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tests\WebsiteBundle\Factory\ControllerFactory;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class LandingPageControllerTest extends AbstractWebTestCase
{
    public function testIndexAction()
    {
        $this->getCrawler([
            'url' => '/tms/',
        ]);

        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testIndexActionForOutdatedBrowser()
    {
        $request = new Request();
        $request->headers->set('user-agent', 'Mozilla/4.0 (MSIE 6.0; Windows NT 5.0)');

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createLandingPageController($request);

        $response = $controller->indexAction();

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
