<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

class UserControllerTest extends AbstractWebTestCase
{
    public function testIndexActionResponse()
    {
        $this->getCrawler('/signout/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect('http://localhost/'));
    }
}
