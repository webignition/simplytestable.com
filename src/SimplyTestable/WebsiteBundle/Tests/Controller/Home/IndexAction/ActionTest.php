<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\Home\IndexAction;

use SimplyTestable\WebsiteBundle\Tests\Controller\ActionTest as BaseActionTest;

class ActionTest extends BaseActionTest {
    
    public function setUp() {
        parent::setUp();        
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath() . '/HttpResponses'));
    }

    protected function getExpectedResponseStatusCode() {
        return 200;
    }
}