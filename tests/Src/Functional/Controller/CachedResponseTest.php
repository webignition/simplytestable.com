<?php

namespace App\Tests\Src\Functional\Controller;

use App\Services\CacheableResponseFactory;
use App\Services\PlansService;
use App\Services\ViewRenderService;
use App\Controller\PageController;
use App\Controller\PlanDetailsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class CachedResponseTest extends AbstractControllerTest
{
    /**
     * @dataProvider actionCallDataProvider
     *
     * @param string $controllerClass
     * @param callable $actionCall
     */
    public function testCachedResponseIsReturned($controllerClass, callable $actionCall)
    {
        $request = new Request();

        self::$container->get('request_stack')->push($request);

        $controller = self::$container->get($controllerClass);

        /* @var Response $response */
        $response = $actionCall($request, $controller);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $responseLastModified = new \DateTime($response->headers->get('last-modified'));
        $responseLastModified->modify('+1 hour');

        $newRequest = $request->duplicate();

        $newRequest->headers->set('if-modified-since', $responseLastModified->format('c'));

        /* @var Response $newResponse */
        $newResponse = $actionCall($newRequest, $controller);

        $this->assertInstanceOf(Response::class, $newResponse);
        $this->assertEquals(Response::HTTP_NOT_MODIFIED, $newResponse->getStatusCode());
    }

    /**
     * @return array
     */
    public function actionCallDataProvider()
    {
        return [
            'Page:home' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (Request $request, PageController $controller) {
                    self::$container->get(RequestStack::class)->push($request);

                    return $controller->homeAction();
                }
            ],
            'Page:plans' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (Request $request, PageController $controller) {
                    self::$container->get(RequestStack::class)->push($request);

                    return $controller->plansAction(self::$container->get(PlansService::class));
                }
            ],
            'Page:features' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (Request $request, PageController $controller) {
                    self::$container->get(RequestStack::class)->push($request);

                    return $controller->featuresAction();
                }
            ],
            'Page:accountBenefits' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (Request $request, PageController $controller) {
                    self::$container->get(RequestStack::class)->push($request);

                    return $controller->accountBenefitsAction(self::$container->get(PlansService::class));
                }
            ],
            'PlanDetails:index/demo' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => $this->createPlanDetailsControllerActionCall('demo'),
            ],
            'PlanDetails:index/personal' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => $this->createPlanDetailsControllerActionCall('personal'),
            ],
            'PlanDetails:index/agency' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => $this->createPlanDetailsControllerActionCall('agency'),
            ],
            'PlanDetails:index/business' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => $this->createPlanDetailsControllerActionCall('business'),
            ],
            'PlanDetails:index/enterprise' => [
                'controllerClass' => PlanDetailsController::class,
                'actionCall' => $this->createPlanDetailsControllerActionCall('enterprise'),
            ],
            'Page:outdatedBrowser' => [
                'controllerClass' => PageController::class,
                'actionCall' => function (Request $request, PageController $controller) {
                    self::$container->get(RequestStack::class)->push($request);

                    return $controller->outdatedBrowserAction();
                }
            ],
        ];
    }

    private function createPlanDetailsControllerActionCall($planName): callable
    {
        return function (Request $request, PlanDetailsController $controller) use ($planName) {
            return $controller->indexAction(
                self::$container->get(CacheableResponseFactory::class),
                self::$container->get(ViewRenderService::class),
                self::$container->get(RouterInterface::class),
                $request,
                self::$container->get(PlansService::class),
                $planName
            );
        };
    }
}
