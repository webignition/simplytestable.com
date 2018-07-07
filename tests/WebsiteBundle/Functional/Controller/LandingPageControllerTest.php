<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\LandingPageController;

class LandingPageControllerTest extends AbstractControllerTest
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
        $request = $this->createRequestForOutdatedBrowser();
        $this->container->get('request_stack')->push($request);

        $controller = $this->container->get(LandingPageController::class);

        $response = $controller->indexAction();

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
