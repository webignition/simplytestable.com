<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\ApplicationConfigurationService;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class ApplicationConfigurationServiceTest extends AbstractWebTestCase
{
    public function testGet()
    {
        $projectRoot = realpath(__DIR__ . '/../../../..');
        $expectedRootDir = $projectRoot . '/app';
        $expectedWebDir = $projectRoot . '/web';

        $applicationConfigurationService = $this->container->get(ApplicationConfigurationService::class);

        $this->assertEquals('http://local.simplytestable.com', $applicationConfigurationService->getBaseUrl());
        $this->assertEquals($expectedRootDir, $applicationConfigurationService->getRootDir());
        $this->assertRegExp('/\/var\/cache\/test$/', $applicationConfigurationService->getCacheDir());
        $this->assertEquals($expectedWebDir, $applicationConfigurationService->getWebDir());
    }
}
