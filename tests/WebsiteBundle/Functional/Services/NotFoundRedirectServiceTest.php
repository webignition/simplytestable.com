<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Services\NotFoundRedirectService;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class NotFoundRedirectServiceTest extends AbstractWebTestCase
{
    public function testGetAsService()
    {
        $this->assertInstanceOf(
            NotFoundRedirectService::class,
            $this->container->get('simplytestable.services.notfoundredirectservice')
        );
    }

    /**
     * @dataProvider hasRedirectForDataProvider
     *
     * @param string $url
     * @param string $expectedHasRedirectFor
     */
    public function testHasRedirectFor($url, $expectedHasRedirectFor)
    {
        $notFoundRedirectService = $this->container->get('simplytestable.services.notfoundredirectservice');

        $this->assertEquals($expectedHasRedirectFor, $notFoundRedirectService->hasRedirectFor($url));
    }

    /**
     * @return array
     */
    public function hasRedirectForDataProvider()
    {
        return [
            '/foo' => [
                'url' => '/foo',
                'expectedHasRedirectFor' => false,
            ],
            '/index.php' => [
                'url' => '/index.php',
                'expectedHasRedirectFor' => true,
            ],
            '/signup.php' => [
                'url' => '/index.php',
                'expectedHasRedirectFor' => true,
            ],
            '/signup' => [
                'url' => '/index.php',
                'expectedHasRedirectFor' => true,
            ],
            '/register.php' => [
                'url' => '/index.php',
                'expectedHasRedirectFor' => true,
            ],
        ];
    }

    /**
     * @dataProvider getRedirectForDataProvider
     *
     * @param string $url
     * @param string $expectedRedirectUrl
     */
    public function testGetRedirectFor($url, $expectedRedirectUrl)
    {
        $notFoundRedirectService = $this->container->get('simplytestable.services.notfoundredirectservice');

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
