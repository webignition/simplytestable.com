<?php

namespace Tests\WebsiteBundle\Functional\Services;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class ApplicationConfigurationServiceTest extends AbstractWebTestCase
{
    public function testGet()
    {
        $projectRoot = realpath(__DIR__ . '/../../../..');
        $expectedRootDir = $projectRoot . '/app';
        $expectedWebDir = $projectRoot . '/web';

        $applicationConfigurationService = $this->testServiceProvider->getApplicationConfigurationService();

        $this->assertEquals($expectedRootDir, $applicationConfigurationService->getRootDir());
        $this->assertRegExp('/\/var\/cache\/test$/', $applicationConfigurationService->getCacheDir());
        $this->assertEquals($expectedWebDir, $applicationConfigurationService->getWebDir());
    }
}
