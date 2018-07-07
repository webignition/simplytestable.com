<?php

namespace Tests\AppBundle\Functional\Controller;

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
            '/',
            '/plans/',
            '/features/',
            '/account-benefits/',
            '/plans/demo/',
            '/plans/free/',
            '/plans/personal/',
            '/plans/agency/',
            '/plans/business/',
            '/plans/enterprise/',
            '/tms/',
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
                'expectedResponseLocation' => 'http://localhost/outdated-browser/',
            ],
            'IE7' => [
                'userAgent' => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
                'expectedStatusCode' => 302,
                'expectedResponseLocation' => 'http://localhost/outdated-browser/',
            ],
            'IE8' => [
                'userAgent' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)',
                'expectedStatusCode' => 302,
                'expectedResponseLocation' => 'http://localhost/outdated-browser/',
            ],
            'IE9' => [
                'userAgent' => 'Mozilla/5.0 (Windows; U; MSIE 9.0; WIndows NT 9.0; en-US))',
                'expectedStatusCode' => 302,
                'expectedResponseLocation' => 'http://localhost/outdated-browser/',
            ],
            'IE10' => [
                'userAgent' => 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
                'expectedStatusCode' => 200,
                'expectedResponseLocation' => null,
            ],
            'Chrome 64 Windows' => [
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) '
                    .'Chrome/64.0.3282.186 Safari/537.36',
                'expectedStatusCode' => 200,
                'expectedResponseLocation' => null,
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
