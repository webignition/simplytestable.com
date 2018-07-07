<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\PageController;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\TestServiceProvider;

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
     * @dataProvider actionCallDataProvider
     *
     * @param callable $actionCall
     */
    public function testActionHasResponse(callable $actionCall)
    {
        $request = new Request();
        $this->container->get('request_stack')->push($request);

        $response = new Response();
        $this->controller->setResponse($response);

        $retrievedResponse = $actionCall($this->controller, $this->testServiceProvider);

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    /**
     * @dataProvider actionCallDataProvider
     *
     * @param callable $actionCall
     */
    public function testActionForOutdatedBrowser(callable $actionCall)
    {
        $request = $this->createRequestForOutdatedBrowser();
        $this->container->get('request_stack')->push($request);

        /* @var Response $response */
        $response = $actionCall($this->controller, $this->testServiceProvider);

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }

    /**
     * @return array
     */
    public function actionCallDataProvider()
    {
        return [
            'homeAction' => [
                'actionCall' => function (PageController $pageController) {
                    return $pageController->homeAction();
                }
            ],
            'plansAction' => [
                'actionCall' => function (PageController $pageController, TestServiceProvider $testServiceProvider) {
                    return $pageController->plansAction($testServiceProvider->getPlansService());
                }
            ],
            'featuresAction' => [
                'actionCall' => function (PageController $pageController) {
                    return $pageController->featuresAction();
                }
            ],
            'accountBenefitsAction' => [
                'actionCall' => function (PageController $pageController, TestServiceProvider $testServiceProvider) {
                    return $pageController->accountBenefitsAction($testServiceProvider->getPlansService());
                }
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
