<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\UserAgentDetector;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class UserAgentDetectorTest extends AbstractWebTestCase
{
    public function testGetAsService()
    {
        $this->assertInstanceOf(
            UserAgentDetector::class,
            $this->container->get(UserAgentDetector::class)
        );
    }
}
