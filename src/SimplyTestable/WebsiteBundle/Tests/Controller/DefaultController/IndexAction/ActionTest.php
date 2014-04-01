<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\IndexAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController\ActionTest as BaseActionTest;

class ActionTest extends BaseActionTest {    
    
    public function setUp() {
        parent::setUp();
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));
    }     
    
    protected function getActionName() {
        return 'indexAction';
    }
    
    public function testPageIsRendered() {        
        $this->performActionTest(array(
            'statusCode' => 200
        ));
    }
}