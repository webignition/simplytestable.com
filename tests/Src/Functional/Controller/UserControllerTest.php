<?php

namespace App\Tests\Src\Functional\Controller;

use App\Tests\Src\Functional\AbstractWebTestCase;

class UserControllerTest extends AbstractWebTestCase
{
    public function testIndexActionResponse()
    {
        $this->getCrawler([
            'url' => '/signout/',
        ]);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('/'));
    }
}
