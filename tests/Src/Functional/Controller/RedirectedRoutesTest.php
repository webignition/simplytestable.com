<?php

namespace App\Tests\Src\Functional\Controller;

use App\Tests\Src\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RedirectedRoutesTest extends AbstractWebTestCase
{
    /**
     * @dataProvider redirectedRouteDataProvider
     *
     * @param string $path
     * @param string $expectedRedirectUrl
     */
    public function testRedirectedRoute(string $path, string $expectedRedirectUrl)
    {
        $this->getCrawler([
            'url' => $path,
        ]);

        /* @var RedirectResponse $response */
        $response = $this->getClientResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);

        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $response->getStatusCode());
        $this->assertEquals($expectedRedirectUrl, $response->getTargetUrl());
    }

    /**
     * @return array
     */
    public function redirectedRouteDataProvider()
    {
        return [
            '/demo' => [
                'path' => '/demo',
                'expectedRedirectUrl' => 'http://localhost/plans/demo'
            ],
            '/free' => [
                'path' => '/free',
                'expectedRedirectUrl' => 'http://localhost/plans/free'
            ],
            '/personal' => [
                'path' => '/personal',
                'expectedRedirectUrl' => 'http://localhost/plans/personal'
            ],
            '/agency' => [
                'path' => '/agency',
                'expectedRedirectUrl' => 'http://localhost/plans/agency'
            ],
            '/business' => [
                'path' => '/business',
                'expectedRedirectUrl' => 'http://localhost/plans/business'
            ],
            '/enterprise' => [
                'path' => '/enterprise',
                'expectedRedirectUrl' => 'http://localhost/plans/enterprise'
            ],
            '/legal/privacy' => [
                'path' => '/legal/privacy',
                'expectedRedirectUrl' => 'https://help.simplytestable.com/legal/privacy/'
            ],
            '/legal/terms-of-service' => [
                'path' => '/legal/terms-of-service',
                'expectedRedirectUrl' => 'https://help.simplytestable.com/legal/terms-of-service/'
            ],
        ];
    }
}
