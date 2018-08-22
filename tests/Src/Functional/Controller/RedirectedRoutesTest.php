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
            '/enterprise' => [
                'path' => '/enterprise',
                'expectedRedirectUrl' => 'http://localhost/plans/enterprise'
            ],
            '/personal' => [
                'path' => '/personal',
                'expectedRedirectUrl' => 'http://localhost/plans/personal'
            ],
        ];
    }
}
