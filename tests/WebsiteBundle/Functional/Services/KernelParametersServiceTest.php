<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\KernelParametersService;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class KernelParametersServiceTest extends AbstractWebTestCase
{
    public function testGetRootDirGetWebDir()
    {
        $projectRoot = realpath(__DIR__ . '/../../../..');
        $expectedRootDir = $projectRoot . '/app';
        $expectedWebDir = $projectRoot . '/web';

        $kernelParametersService = $this->container->get(KernelParametersService::class);

        $this->assertEquals($expectedRootDir, $kernelParametersService->getRootDir());
        $this->assertEquals($expectedWebDir, $kernelParametersService->getWebDir());
    }
}
