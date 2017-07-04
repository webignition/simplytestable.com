<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    public function testIndexActionInvalidPlan()
    {
        $this->client->request('GET', '/plans/foo/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('/plans/'));
    }
}
