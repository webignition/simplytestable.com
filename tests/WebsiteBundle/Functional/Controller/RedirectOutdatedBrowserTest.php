<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class RedirectOutdatedBrowserTest extends AbstractWebTestCase
{
    /**
     * @dataProvider redirectOutdatedBrowserDataProvider
     *
     * @param $url
     * @param $userAgentString
     * @param $expectedStatusCode
     * @param $expectedResponseLocation
     */
    public function testRedirectOutdatedBrowser($url, $userAgentString, $expectedStatusCode, $expectedResponseLocation)
    {
        $this->getCrawler([
            'url' => $url,
            'server' => [
                'HTTP_USER_AGENT' => $userAgentString,
            ],
        ]);

        $response = $this->getClientResponse();

        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
        $this->assertEquals($expectedResponseLocation, $response->headers->get('location'));
    }
    /**
     * @return array
     */
    public function redirectOutdatedBrowserDataProvider()
    {
        $urls = [
//            '/',
//            '/tms/',
//            '/plans/',
//            '/features/',
//            '/roadmap/',
            '/account-benefits/',
//            '/plans/demo/',
//            '/plans/free/',
//            '/plans/personal/',
//            '/plans/agency/',
//            '/plans/business/',
//            '/plans/enterprise/',
        ];

        $sourceTestDataCollection = [
            'no user agent' => [
                'userAgentString' => '',
                'expectedStatusCode' => 200,
                'expectedResponseLocation' => null,
            ],
            'IE6' => [
                'userAgentString' => 'Mozilla/4.0 (compatible; MSIE 6.1; Windows XP)',
                'expectedStatusCode' => 302,
                'expectedResponseLocation' => '/outdated-browser/',
            ],
        ];

        $testDataCollection = [];

        foreach ($urls as $url) {
            foreach ($sourceTestDataCollection as $sourceTestName => $sourceTestData) {
                $testName = sprintf('%s: %s', $sourceTestName, $url);
                $testData = array_merge([
                    'url' => $url,
                ], $sourceTestData);

                $testDataCollection[$testName] = $testData;
            }
        }

        return $testDataCollection;
    }
}
