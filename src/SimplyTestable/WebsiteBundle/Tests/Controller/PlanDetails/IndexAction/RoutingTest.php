<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\PlanDetails\IndexAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\RoutingTest as BaseRoutingTest;

class RoutingTest extends BaseRoutingTest {

    protected function getRouteParameters() {
        return array(
            'name' => 'demo'
        );
    }

}