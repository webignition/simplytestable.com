<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\PlanDetails\IndexAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\ActionTest as BaseActionTest;

class InvalidPlanRedirectsTest extends BaseActionTest {
    
    protected function getActionMethodArguments() {
        return array(
            'name' => 'foo'
        );
    }

    protected function getExpectedResponseStatusCode() {
        return 302;
    }
}