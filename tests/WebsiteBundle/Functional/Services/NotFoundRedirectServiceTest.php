<?php

namespace Tests\WebsiteBundle\Functional\Services;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class NotFoundRedirectServiceTest extends AbstractWebTestCase
{
    public function testGetRedirectFor()
    {
        $notFoundRedirectService = $this->testServiceProvider->getNotFoundRedirectService();

        foreach ($this->getRedirectForDataProvider() as $testData) {
            $this->assertEquals(
                $testData['expectedRedirectUrl'],
                $notFoundRedirectService->getRedirectFor($testData['url'])
            );
        }
    }

    /**
     * @return array
     */
    public function getRedirectForDataProvider()
    {
        return [
            '/foo' => [
                'url' => '/foo',
                'expectedRedirectUrl' => '',
            ],
            '/index.php' => [
                'url' => '/index.php',
                'expectedRedirectUrl' => 'http://local.simplytestable.com/',
            ],
            '/app_dev.php/index.php' => [
                'url' => '/app_dev.php/index.php',
                'expectedRedirectUrl' => 'http://local.simplytestable.com/',
            ],
            '/signup.php' => [
                'url' => '/signup.php',
                'expectedRedirectUrl' => 'http://web.client.simplytestable.com/signup/',
            ],
            '/signup' => [
                'url' => '/signup',
                'expectedRedirectUrl' => 'http://web.client.simplytestable.com/signup/',
            ],
            '/signup/' => [
                'url' => '/signup/',
                'expectedRedirectUrl' => 'http://web.client.simplytestable.com/signup/',
            ],
            '/register.php' => [
                'url' => '/register.php',
                'expectedRedirectUrl' => 'http://web.client.simplytestable.com/signup/',
            ],
        ];
    }
}
