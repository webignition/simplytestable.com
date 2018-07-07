<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Tests\WebsiteBundle\DataProvider\RouteDataProviderTrait;

class RenderSuccessResponseTest extends AbstractControllerTest
{
    use RouteDataProviderTrait;

    const USER_EMAIL = 'user@example.com';

    /**
     * @dataProvider routeDataProvider
     *
     * @param string $url
     */
    public function testCachedResponseIsReturned($url)
    {
        $this->client->request('GET', $url);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }
}
