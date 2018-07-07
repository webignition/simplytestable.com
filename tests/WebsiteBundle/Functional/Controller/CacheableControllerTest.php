<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Doctrine\ORM\EntityRepository;
use SimplyTestable\WebsiteBundle\Controller\OutdatedBrowserController;
use SimplyTestable\WebsiteBundle\Controller\PageController;
use SimplyTestable\WebsiteBundle\Controller\PlanDetailsController;
use SimplyTestable\WebsiteBundle\Entity\CacheValidatorHeaders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\TestServiceProvider;

class CacheableControllerTest extends AbstractControllerTest
{
    const USER_EMAIL = 'user@example.com';

    /**
     * @dataProvider actionCallDataProvider
     *
     * @param string $controllerClass
     * @param callable $actionCall
     */
    public function testSetControllerResponse($controllerClass, callable $actionCall)
    {
        $controller = $this->container->get($controllerClass);

        $request = new Request();
        $this->container->get('request_stack')->push($request);

        $response = new Response();
        $controller->setResponse($response);

        $retrievedResponse = $actionCall($controller, $this->testServiceProvider);

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    /**
     * @return array
     */
    public function actionCallDataProvider()
    {
        return [
            'Page:home' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (PageController $controller) {
                    return $controller->homeAction();
                }
            ],
            'Page:plans' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (PageController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->plansAction($testServiceProvider->getPlansService());
                }
            ],
            'Page:features' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (PageController $controller) {
                    return $controller->featuresAction();
                }
            ],
            'Page:accountBenefits' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (PageController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->accountBenefitsAction($testServiceProvider->getPlansService());
                }
            ],
            'PlanDetails:index/demo' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => function (PlanDetailsController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->indexAction(
                        $testServiceProvider->getPlansService(),
                        'demo'
                    );
                }
            ],
            'PlanDetails:index/personal' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => function (PlanDetailsController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->indexAction(
                        $testServiceProvider->getPlansService(),
                        'personal'
                    );
                }
            ],
            'PlanDetails:index/agency' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => function (PlanDetailsController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->indexAction(
                        $testServiceProvider->getPlansService(),
                        'agency'
                    );
                }
            ],
            'PlanDetails:index/business' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => function (PlanDetailsController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->indexAction(
                        $testServiceProvider->getPlansService(),
                        'business'
                    );
                }
            ],
            'PlanDetails:index/enterprise' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => function (PlanDetailsController $controller, TestServiceProvider $testServiceProvider) {
                    return $controller->indexAction(
                        $testServiceProvider->getPlansService(),
                        'enterprise'
                    );
                }
            ],
            'OutdatedBrowser:index' => [
                'controllerClass' => OutdatedBrowserController::class,
                'actionCall' => function (OutdatedBrowserController $controller) {
                    return $controller->indexAction();
                }
            ],
        ];
    }

    /**
     * @dataProvider cachedResponseHandlingDataProvider
     *
     * @param string $url
     * @param string $ifNoneMatchHeader
     * @param array $expectedCacheValidatorHeaderParameters
     */
    public function testCachedResponseIsReturned(
        $url,
        $ifNoneMatchHeader,
        array $expectedCacheValidatorHeaderParameters
    ) {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        /* @var EntityRepository $cacheValidatorHeadersEntityRepository */
        $cacheValidatorHeadersEntityRepository = $entityManager->getRepository(CacheValidatorHeaders::class);

        $this->setUser(
            $this->createUser(self::USER_EMAIL)
        );

        $this->getCrawler([
            'url' => $url,
            'server' => [
                'HTTP_IF_NONE_MATCH' => $ifNoneMatchHeader,
            ],
        ]);

        $this->assertEquals(304, $this->getClientResponse()->getStatusCode());

        /* @var CacheValidatorHeaders $cacheValidatorHeaders */
        $cacheValidatorHeaders = $cacheValidatorHeadersEntityRepository->findAll()[0];
        $cacheValidatorIdentifier = $cacheValidatorHeaders->getIdentifier();

        $this->assertArraySubset($expectedCacheValidatorHeaderParameters, $cacheValidatorIdentifier->getParameters());
    }

    /**
     * @return array
     */
    public function cachedResponseHandlingDataProvider()
    {
        return [
            'home' => [
                'url' => '/',
                'ifNoneMatchHeader' => '"11bb9bf941ca9b19312cfaf3008a696d"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'home_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans' => [
                'url' => '/plans/',
                'ifNoneMatchHeader' => '"70b5eedf6f8f90c8728d76d37df743e1"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'page_plans',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'features' => [
                'url' => '/features/',
                'ifNoneMatchHeader' => '"4cf900a15c1402509dd0717639c26c7a"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'page_features',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'account-benefits' => [
                'url' => '/account-benefits/',
                'ifNoneMatchHeader' => '"516745ab81f74641ae7206c7c051aeeb"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'page_accountbenefits',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans/demo' => [
                'url' => '/plans/demo/',
                'ifNoneMatchHeader' => '"0f9e707c19e7d73ac5835c5cd771a5c8"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'plandetails_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans/personal' => [
                'url' => '/plans/personal/',
                'ifNoneMatchHeader' => '"0f9e707c19e7d73ac5835c5cd771a5c8"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'plandetails_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans/agency' => [
                'url' => '/plans/agency/',
                'ifNoneMatchHeader' => '"0f9e707c19e7d73ac5835c5cd771a5c8"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'plandetails_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans/business' => [
                'url' => '/plans/business/',
                'ifNoneMatchHeader' => '"0f9e707c19e7d73ac5835c5cd771a5c8"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'plandetails_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'plans/enterprise' => [
                'url' => '/plans/enterprise/',
                'ifNoneMatchHeader' => '"0f9e707c19e7d73ac5835c5cd771a5c8"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'plandetails_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
            'outdated-browser' => [
                'url' => '/outdated-browser/',
                'ifNoneMatchHeader' => '"994c1c6eae47fe7463e26604b196feb0"',
                'expectedCacheValidatorHeaderParameters' => [
                    'route' => 'outdatedbrowser_index',
                    'user' => self::USER_EMAIL,
                    'is_logged_in' => true,
                ],
            ],
        ];
    }
}
