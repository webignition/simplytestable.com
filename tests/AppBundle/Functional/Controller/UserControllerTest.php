<?php

namespace Tests\AppBundle\Functional\Controller;

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
