<?php

namespace Tests\Src\Functional\Controller;

use Tests\Src\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider indexActionRedirectDataProvider
     *
     * @param string $url
     * @param string $expectedRedirectLocation
     */
    public function testIndexActionRedirect($url, $expectedRedirectLocation)
    {
        $this->client->request('GET', $url);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect($expectedRedirectLocation));
    }

    /**
     * @return array
     */
    public function indexActionRedirectDataProvider()
    {
        return [
            'invalid plan' => [
                'url' => '/plans/foo/',
                'expectedRedirectLocation' => 'http://localhost/plans/'
            ],
            'premium => agency' => [
                'url' => '/plans/premium/',
                'expectedRedirectLocation' => 'http://localhost/plans/agency/'
            ],
        ];
    }
}
