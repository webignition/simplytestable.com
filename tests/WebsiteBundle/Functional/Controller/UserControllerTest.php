<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class UserControllerTest extends AbstractWebTestCase
{
    public function testIndexActionResponse()
    {
        $this->getCrawler([
            'url' => '/signout/',
        ]);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('http://localhost/'));
    }
}
