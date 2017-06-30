<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider indexActionDataProvider
     *
     * @param string $name
     */
    public function testIndexActionSuccess($name)
    {
        $this->client->request('GET', '/plans/' . $name . '/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @return array
     */
    public function indexActionDataProvider()
    {
        return [
            'demo' => [
                'name' => 'demo',
            ],
            'free' => [
                'name' => 'free',
            ],
            'personal' => [
                'name' => 'personal',
            ],
            'agency' => [
                'name' => 'agency',
            ],
            'business' => [
                'name' => 'business',
            ],
            'enterprise' => [
                'name' => 'enterprise',
            ],
            'premium' => [
                'name' => 'premium',
            ],
        ];
    }

    public function testIndexActionInvalidPlan()
    {
        $this->client->request('GET', '/plans/foo/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('/plans/'));
    }
}
