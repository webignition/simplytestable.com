<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Services\UserAgentDetector;
use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;

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
