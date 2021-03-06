<?php

namespace App\Tests\Src\Functional\Controller;

use App\Tests\Src\Functional\AbstractWebTestCase;

class ExceptionControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider showActionDataProvider
     *
     * @param string $url
     * @param int $expectedResponseStatusCode
     */
    public function testShowAction($url, $expectedResponseStatusCode)
    {
        $this->getCrawler([
            'url' => $url,
        ]);

        $response = $this->getClientResponse();

        $this->assertEquals($expectedResponseStatusCode, $response->getStatusCode());
    }

    /**
     * @return array
     */
    public function showActionDataProvider()
    {
        return [
            '404 no redirect' => [
                'url' => '/foo',
                'expectedResponseStatusCode' => 404,
            ],
        ];
    }
}
