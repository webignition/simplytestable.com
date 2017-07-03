<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class OutdatedBrowserControllerTest extends AbstractWebTestCase
{
    public function testIndexAction()
    {
        $this->client->request('GET', '/outdated-browser/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }
}
