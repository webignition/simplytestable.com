<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Services\UserAgentDetector;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class UserAgentDetectorTest extends AbstractWebTestCase
{
    public function testGetAsService()
    {
        $this->assertInstanceOf(
            UserAgentDetector::class,
            $this->container->get('simplytestable.services.useragentdetector')
        );
    }
}
