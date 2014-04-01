<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\PlansAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\ActionTest as BaseActionTest;

class ActionTest extends BaseActionTest {    
    
    public function setUp() {
        parent::setUp();
    }     
    
    protected function getActionName() {
        return 'plansAction';
    }
    
    public function testPageIsRendered() {        
        $this->performActionTest(array(
            'statusCode' => 200
        ));
    }
}