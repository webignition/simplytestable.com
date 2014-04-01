<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\RoadmapAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\ActionTest as BaseActionTest;

class ActionTest extends BaseActionTest {    
    
    public function setUp() {
        parent::setUp();
    }
    
    public function testPageIsRendered() {        
        $this->performActionTest(array(
            'statusCode' => 200
        ));
    }
}