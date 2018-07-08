<?php

namespace Tests\Src\Functional\Services;

use Tests\Src\Functional\AbstractWebTestCase;

class NotFoundRedirectServiceTest extends AbstractWebTestCase
{
    /**
     * @dataProvider getRedirectForDataProvider
     *
     * @param $url
     * @param $expectedRedirectUrl
     */
    public function testGetRedirectFor($url, $expectedRedirectUrl)
    {
        $notFoundRedirectService = $this->testServiceProvider->getNotFoundRedirectService();

        $this->assertEquals(
            $expectedRedirectUrl,
            $notFoundRedirectService->getRedirectFor($url)
        );
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
