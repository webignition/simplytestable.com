<?php

namespace SimplyTestable\WebsiteBundle\Tests\Functional\Controller;

use SimplyTestable\WebsiteBundle\Tests\Functional\AbstractWebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class HomeControllerTest extends AbstractWebTestCase
{
    public function testIndexActionResponse()
    {
        $this->getCrawler('/');
        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    public function testIndexActionContentForPublicUser()
    {
        $crawler = $this->getCrawler('/');

        $signInOutButton = $this->getNavbar($crawler)->filter('a:contains("Sign in")');
        $this->assertCount(1, $signInOutButton);
        $this->assertEquals(
            ['http://web.client.simplytestable.com/signin/'],
            $signInOutButton->extract(['href'])
        );

        $createAccountButton = $this->getNavbar($crawler)->filter('a:contains("Create an account")');
        $this->assertCount(1, $createAccountButton);
        $this->assertEquals(
            ['http://web.client.simplytestable.com/signup/'],
            $createAccountButton->extract(['href'])
        );
    }

    public function testIndexActionContentForPrivateUser()
    {
        $this->setUser(
            $this->createUser('user@example.com')
        );

        $crawler = $this->getCrawler('/');

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
     * @param Crawler $crawler
     *
     * @return Crawler
     */
    private function getNavbar(Crawler $crawler)
    {
        return $crawler->filter('.navbar');
    }
}
