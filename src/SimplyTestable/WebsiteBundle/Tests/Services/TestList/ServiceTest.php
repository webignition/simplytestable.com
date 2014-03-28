<?php

namespace SimplyTestable\WebsiteBundle\Tests\Services\TestList;

use SimplyTestable\WebsiteBundle\Tests\BaseSimplyTestableTestCase;

class ServiceTest extends BaseSimplyTestableTestCase {
    
    public function testGetList() {        
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        $this->assertEquals(3, count($list));
    }
    
    
    public function testCurlErrorResultsInEmptyList() {
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        $this->assertEquals(0, count($list));        
    }
    
    public function testHttpErrorResultsInEmptyList() {
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        $this->assertEquals(0, count($list));        
    }    

}
