<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Doctrine\ORM\EntityRepository;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;
use Symfony\Component\DomCrawler\Crawler;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class HomeControllerTest extends AbstractWebTestCase
{
    public function testEventListenerOrder()
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        /* @var EntityRepository $cacheValidatorHeadersEntityRepository */
        $cacheValidatorHeadersEntityRepository = $entityManager->getRepository(CacheValidatorHeaders::class);

        $this->setUser(
            $this->createUser('user@example.com')
        );

        $this->getCrawler([
            'url' => '/',
            'server' => [
                'HTTP_IF_NONE_MATCH' => '"11bb9bf941ca9b19312cfaf3008a696d"',
            ],
        ]);

        $this->assertEquals(304, $this->getClientResponse()->getStatusCode());

        /* @var CacheValidatorHeaders $cacheValidatorHeaders */
        $cacheValidatorHeaders = $cacheValidatorHeadersEntityRepository->findAll()[0];
        $cacheValidatorIdentifier = $cacheValidatorHeaders->getIdentifier();

        $this->assertArraySubset([
            'route' => 'home_index',
            'user' => 'user@example.com',
            'is_logged_in' => true,
        ], $cacheValidatorIdentifier->getParameters());
    }

    public function testIndexActionContentForPublicUser()
    {
        $crawler = $this->getCrawler([
            'url' => '/',
        ]);

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

        $crawler = $this->getCrawler([
            'url' => '/',
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
     * @param Crawler $crawler
     *
     * @return Crawler
     */
    private function getNavbar(Crawler $crawler)
    {
        return $crawler->filter('.navbar');
    }
}
