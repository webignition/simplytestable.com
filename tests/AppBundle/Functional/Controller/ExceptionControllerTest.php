<?php

namespace Tests\AppBundle\Functional\Controller;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

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
            '404 has redirect' => [
                'url' => '/signup.php',
                'expectedResponseStatusCode' => 302,
            ],
            '404 app_dev.php has redirect' => [
                'url' => '/app_dev.php/signup.php',
                'expectedResponseStatusCode' => 302,
            ],
            '404 no redirect' => [
                'url' => '/foo',
                'expectedResponseStatusCode' => 404,
            ],
        ];
    }
}
