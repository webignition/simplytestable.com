<?php

namespace Tests\WebsiteBundle\Functional\Services;

use SimplyTestable\WebsiteBundle\Services\WebClientRouter;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class CoreApplicationRouterTest extends AbstractWebTestCase
{
    public function testGenerateAll()
    {
        $webClientRouter = $this->container->get(WebClientRouter::class);
        $this->assertEquals(
            [
                'start_test' => 'http://web.client.simplytestable.com/',
                'sign_in' => 'http://web.client.simplytestable.com/signin/',
                'sign_up' => 'http://web.client.simplytestable.com/signup/',
                'account' => 'http://web.client.simplytestable.com/account/',
                'plan_subscribe' => 'http://web.client.simplytestable.com/account/plan/subscribe/',
                'history' => 'http://web.client.simplytestable.com/history/',
            ],
            $webClientRouter->generateAll()
        );
    }
}
