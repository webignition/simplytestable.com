<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class PageControllerTest extends AbstractWebTestCase
{
    public function testPlansAction()
    {
        $this->client->request('GET', '/plans/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testFeaturesAction()
    {
        $this->client->request('GET', '/features/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testRoadmapAction()
    {
        $this->client->request('GET', '/roadmap/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testAccountBenefitsAction()
    {
        $this->client->request('GET', '/account-benefits/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }
}
