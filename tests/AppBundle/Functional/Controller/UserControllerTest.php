<?php

namespace Tests\AppBundle\Functional\Controller;

use Tests\AppBundle\Functional\AbstractWebTestCase;

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
