<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Doctrine\ORM\EntityRepository;
use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class HomeControllerTest extends AbstractControllerTest
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

    public function testIndexActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createHomeController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->indexAction();

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testIndexActionForOutdatedBrowser()
    {
        $request = $this->createRequestForOutdatedBrowser();

        $controllerFactory = new ControllerFactory($this->container);
        $controller = $controllerFactory->createHomeController($request);

        $response = $controller->indexAction();

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
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
