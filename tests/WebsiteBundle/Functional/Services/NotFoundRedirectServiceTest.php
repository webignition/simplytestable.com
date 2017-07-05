<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\NotFoundRedirectService;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class NotFoundRedirectServiceTest extends AbstractWebTestCase
{
    /**
     * @dataProvider getRedirectForDataProvider
     *
     * @param string $url
     * @param string $expectedRedirectUrl
     */
    public function testGetRedirectFor($url, $expectedRedirectUrl)
    {
        $notFoundRedirectService = $this->container->get(NotFoundRedirectService::class);

        $this->assertEquals($expectedRedirectUrl, $notFoundRedirectService->getRedirectFor($url));
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
