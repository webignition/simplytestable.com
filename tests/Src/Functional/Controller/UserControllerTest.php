<?php

namespace Tests\Src\Functional\Controller;

use Tests\Src\Functional\AbstractWebTestCase;

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
