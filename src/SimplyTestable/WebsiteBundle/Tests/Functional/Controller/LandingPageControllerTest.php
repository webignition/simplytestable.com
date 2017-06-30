<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class LandingPageControllerTest extends AbstractWebTestCase
{
    public function testIndexActionResponse()
    {
        $this->getCrawler('/tms/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }
}
