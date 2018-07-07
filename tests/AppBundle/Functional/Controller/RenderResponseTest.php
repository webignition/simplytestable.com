<?php

namespace Tests\AppBundle\Functional\Controller;

use Symfony\Component\DomCrawler\Crawler;
use Tests\WebsiteBundle\DataProvider\RouteDataProviderTrait;

class RenderResponseTest extends AbstractControllerTest
{
    use RouteDataProviderTrait;

    const USER_EMAIL = 'user@example.com';

    /**
     * @dataProvider routeDataProvider
     *
     * @param string $url
     */
    public function testResponseIsSuccessful($url)
    {
        $this->client->request('GET', $url);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @dataProvider routesForPagesWithNavBarDataProvider
     *
     * @param string $url
     */
    public function testNavBarContentForPublicUser($url)
    {
        $crawler = $this->getCrawler([
            'url' => $url,
        ]);

        $signInOutButton = $this->getNavBar($crawler)->filter('a:contains("Sign in")');
        $this->assertCount(1, $signInOutButton);
        $this->assertEquals(
            ['http://web.client.simplytestable.com/signin/'],
            $signInOutButton->extract(['href'])
        );

        $createAccountButton = $this->getNavBar($crawler)->filter('a:contains("Create an account")');
        $this->assertCount(1, $createAccountButton);
        $this->assertEquals(
            ['http://web.client.simplytestable.com/signup/'],
            $createAccountButton->extract(['href'])
        );
    }

    /**
     * @dataProvider routesForPagesWithNavBarDataProvider
     *
     * @param string $url
     */
    public function testNavBarContentForPrivateUser($url)
    {
        $this->setUser(
            $this->createUser(self::USER_EMAIL)
        );

        $crawler = $this->getCrawler([
            'url' => $url,
        ]);

        $accountLinkButton = $this->getNavbar($crawler)->filter('a:contains("'.$this->getUser()->getUsername().'")');
        $this->assertCount(1, $accountLinkButton);
        $this->assertEquals(
            ['http://web.client.simplytestable.com/account/'],
            $accountLinkButton->extract(['href'])
        );

        $signOutButton = $this->getNavbar($crawler)->filter('button:contains("Sign out")');
        $this->assertCount(1, $signOutButton);

        $signOutForm = $this->getNavbar($crawler)->filter('form');
        $this->assertEquals(
            ['/signout/'],
            $signOutForm->extract(['action'])
        );
    }

    /**
     * @return array
     */
    public function routesForPagesWithNavBarDataProvider()
    {
        $routeData = $this->routeDataProvider();

        unset($routeData['outdated-browser']);

        return $routeData;
    }

    /**
     * @param Crawler $crawler
     *
     * @return Crawler
     */
    private function getNavBar(Crawler $crawler)
    {
        return $crawler->filter('.navbar');
    }
}
