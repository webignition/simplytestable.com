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
    
    
    public function testTestResultUrls() {
        $expectedViewUrlPaths = array(
            '/http://example.com/0//1/results/',
            '/http://example.com/1//2/results/',
            '/http://example.com/2//3/results/',
        );
        
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        foreach ($list as $index => $test) {
            $this->assertTrue(substr_count($test->results_url, $expectedViewUrlPaths[$index]) === 1);
        }  
    }
    
    
    public function testTestProgressUrls() {
        $expectedViewUrlPaths = array(
            '/http://example.com/0//1/progress/',
            '/http://example.com/1//2/progress/',
            '/http://example.com/2//3/progress/',
        );
        
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        foreach ($list as $index => $test) {            
            $this->assertTrue(substr_count($test->progress_url, $expectedViewUrlPaths[$index]) === 1);
        }  
    } 
    
    public function testFormattedWebsite() {
        $expectedFormattedUrls = array(
            'example.com/0/',
            'example.com/1/',
            'example.com/2/',
        );
        
        $this->setHttpFixtures($this->getHttpFixtures($this->getFixturesDataPath($this->getName() . '/HttpResponses')));        
        $this->getTestListService()->setUser($this->getUser());
        
        $list = $this->getTestListService()->getTests();
        
        foreach ($list as $index => $test) {            
            $this->assertTrue(substr_count($test->formatted_website, $expectedFormattedUrls[$index]) === 1);
        }  
    }     

}
