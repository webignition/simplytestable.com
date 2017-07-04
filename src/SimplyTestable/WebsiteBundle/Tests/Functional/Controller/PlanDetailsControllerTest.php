<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    public function testIndexActionInvalidPlan()
    {
        $this->client->request('GET', '/plans/foo/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('/plans/'));
    }
}
