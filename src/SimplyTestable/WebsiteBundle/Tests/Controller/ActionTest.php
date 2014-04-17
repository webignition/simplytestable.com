<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller;

use SimplyTestable\WebsiteBundle\Tests\Controller\BaseTest;

abstract class ActionTest extends BaseTest {
    
    
    /**
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;
    
    public function setUp() {
        parent::setUp();
        
        $controller = $this->getCurrentController($this->getRequestPostData(), $this->getRequestQueryData());       

        $this->container->enterScope('request');
        $this->response = call_user_func_array(array($controller, $this->getActionName()), $this->getActionMethodArguments());          
    }
    
    
    abstract protected function getExpectedResponseStatusCode();
    
    protected function getRequestPostData() {
        return array();
    }
    
    protected function getRequestQueryData() {
        return array();
    }
    
    protected function getActionMethodArguments() {
        return array();
    }
    
    public function testResponseStatusCode() {
        $this->assertEquals($this->getExpectedResponseStatusCode(), $this->response->getStatusCode());
    }
    
    
    /**
     * 
     * @param array $responseProperties
     * @param array $methodProperties
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function performActionTest($responseProperties, $methodProperties = array()) {
        $actionName = $this->getActionName();
        $postData = isset($methodProperties['postData']) ? $methodProperties['postData'] : array();
        $queryData = isset($methodProperties['queryData']) ? $methodProperties['queryData'] : array();             
        $methodArguments = isset($methodProperties['methodArguments']) ? $methodProperties['methodArguments'] : array();
        
        $this->container->enterScope('request');
        
        $controller = $this->getCurrentController($postData, $queryData);
        
        /* @var $response \Symfony\Component\HttpFoundation\Response */
        $response = call_user_func_array(array($controller, $actionName), $methodArguments);
        
        $this->assertEquals($responseProperties['statusCode'], $response->getStatusCode());        
        
        if ($response->getStatusCode() == 302) {
            $redirectUrl = new \webignition\Url\Url($response->getTargetUrl());
            $this->assertEquals($responseProperties['redirectPath'], $redirectUrl->getPath());            
        }
        
        if (isset($responseProperties['flash'])) {
            foreach ($responseProperties['flash'] as $key => $expectedValue) {
                $this->assertEquals($expectedValue, $this->container->get('session')->getFlash($key));
            }
        }
        
        if (isset($responseProperties['cookies'])) {
            foreach ($responseProperties['cookies'] as $name => $properties) {
                $this->performCookieTest($name, $properties, $response);
            }
        }
        
        return $response;
    }
    
    private function performCookieTest($name, $properties, $response) {
        $cookieIsPresent = false;
        
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() == $name) {
                $cookieIsPresent = true;
                
                if (isset($properties['value'])) {
                    $this->assertEquals($properties['value'], $cookie->getValue());
                }                  
            }
                                 
        }        
        
        if ($cookieIsPresent === false) {
            $this->fail('Cookie "'.$name.'" not present');
        }
    }

}
