<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\OutdatedBrowserController;
use SimplyTestable\WebsiteBundle\Controller\PageController;
use SimplyTestable\WebsiteBundle\Controller\PlanDetailsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\TestServiceProvider;

class CacheableControllerActionHasResponseTest extends AbstractControllerTest
{
    /**
     * @dataProvider actionCallDataProvider
     *
     * @param string $controllerClass
     * @param callable $actionCall
     */
    public function testActionHasResponse($controllerClass, callable $actionCall)
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
}
