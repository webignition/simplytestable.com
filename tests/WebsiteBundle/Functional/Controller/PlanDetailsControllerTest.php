<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Services\PlansService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider indexActionSuccessDataProvider
     *
     * @param string $planName
     */
    public function testIndexActionSuccess($planName)
    {
        $this->getCrawler([
            'url' => '/plans/' . $planName . '/',
        ]);

        $response = $this->getClientResponse();

        $this->assertTrue($response->isSuccessful());
    }

    /**
     * @return array
     */
    public function indexActionSuccessDataProvider()
    {
        return [
            'demo' => [
                'planName' => 'demo',
            ],
            'free' => [
                'planName' => 'free',
            ],
            'personal' => [
                'planName' => 'personal',
            ],
            'agency' => [
                'planName' => 'agency',
            ],
            'business' => [
                'planName' => 'business',
            ],
            'enterprise' => [
                'planName' => 'enterprise',
            ],
        ];
    }

    /**
     * @dataProvider indexActionRedirectDataProvider
     *
     * @param string $url
     * @param string $expectedRedirectLocation
     */
    public function testIndexActionRedirect($url, $expectedRedirectLocation)
    {
        $this->client->request('GET', $url);
        $response = $this->getClientResponse();

        $this->assertTrue($response->isRedirect($expectedRedirectLocation));
    }

    /**
     * @return array
     */
    public function indexActionRedirectDataProvider()
    {
        return [
            'invalid plan' => [
                'url' => '/plans/foo/',
                'expectedRedirectLocation' => 'http://localhost/plans/'
            ],
            'premium => agency' => [
                'url' => '/plans/premium/',
                'expectedRedirectLocation' => 'http://localhost/plans/agency/'
            ],
        ];
    }

    public function testIndexActionHasResponse()
    {
        $request = new Request();
        $response = new Response();

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPlanDetailsController($request);
        $controller->setResponse($response);

        $retrievedResponse = $controller->indexAction(
            $this->container->get(PlansService::class),
            'demo'
        );

        $this->assertEquals(spl_object_hash($response), spl_object_hash($retrievedResponse));
    }

    public function testIndexActionForOutdatedBrowser()
    {
        $request = new Request();
        $request->headers->set('user-agent', 'Mozilla/4.0 (MSIE 6.0; Windows NT 5.0)');

        $controllerFactory = new ControllerFactory($this->container);

        $controller = $controllerFactory->createPlanDetailsController($request);

        $response = $controller->indexAction(
            $this->container->get(PlansService::class),
            'demo'
        );

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
