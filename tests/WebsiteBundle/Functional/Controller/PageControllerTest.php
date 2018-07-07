<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\PageController;
use Symfony\Component\DomCrawler\Crawler;

class PageControllerTest extends AbstractControllerTest
{
    const USER_EMAIL = 'user@example.com';

    /**
     * @var PageController
     */
    private $controller;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->controller = $this->container->get(PageController::class);
    }

    /**
     * @dataProvider routeDataProvider
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
     * @dataProvider routeDataProvider
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
    public function routeDataProvider()
    {
        return [
            'home' => [
                'url' => '/',
            ],
        ];
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
