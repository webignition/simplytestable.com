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
}
