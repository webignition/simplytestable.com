<?php

namespace SimplyTestable\WebsiteBundle\Tests\Services\ParameterisedUrl;

use SimplyTestable\WebsiteBundle\Tests\BaseSimplyTestableTestCase;

class GenericServiceTest extends BaseSimplyTestableTestCase {
    
    private $service;
    
    public function setUp() {
        parent::setUp();

        $this->service = new \SimplyTestable\WebsiteBundle\Services\ParameterisedUrlService(array(
            'base' => 'http://example.com',
            'foo1' => '/foo1/',
            'foo2' => '/foo2/{bar1}/{bar2}/'
        ));        
    }
    
    
    public function testGetBaseUrl() {
        $this->assertEquals('http://example.com', $this->service->getUrl());
    }
    
    public function testGetFoo1Url() {                
        $this->assertEquals('http://example.com/foo1/', $this->service->getUrl('foo1'));
    }
    
    public function testGetFoo2Url() {                
        $this->assertEquals('http://example.com/foo2/foobar1/foobar2/', $this->service->getUrl('foo2', array(
            'bar1' => 'foobar1',
            'bar2' => 'foobar2'
        )));
    }

}
