<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\PlanDetailsController;
use SimplyTestable\WebsiteBundle\Services\PlansService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\WebsiteBundle\Factory\ControllerFactory;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class PlanDetailsControllerTest extends AbstractWebTestCase
{
    /**
     * @var PlanDetailsController
     */
    private $controller;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->controller = $this->container->get(PlanDetailsController::class);
    }

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

    public function testIndexActionForOutdatedBrowser()
    {
        $request = new Request();
        $request->headers->set('user-agent', 'Mozilla/4.0 (MSIE 6.0; Windows NT 5.0)');
        $this->container->get('request_stack')->push($request);

        $response = $this->controller->indexAction(
            $this->testServiceProvider->getPlansService(),
            'demo'
        );

        $this->assertTrue($response->isRedirect('http://localhost/outdated-browser/'));
    }
}
