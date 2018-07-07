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
}
