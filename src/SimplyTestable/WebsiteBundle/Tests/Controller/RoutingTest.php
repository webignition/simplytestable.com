<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller;

//use SimplyTestable\WebsiteBundle\Tests\BaseSimplyTestableTestCase;
use SimplyTestable\WebsiteBundle\Tests\Controller\BaseTest;

abstract class RoutingTest extends BaseTest {
    
    const ROUTER_MATCH_CONTROLLER_KEY = '_controller';
    
    abstract protected function getRouteParameters();
    
    public function testRouteExists() {
        try {
            $this->getCurrentRequestUrl($this->getRouteParameters());
        } catch (\Symfony\Component\Routing\Exception\RouteNotFoundException $routeNotFoundException) {
            $this->fail('Named route "' . $this->getRouteFromTestNamespace() . '" does not exist');
        } catch (\InvalidArgumentException $invalidArgumentException) {
            $this->fail($invalidArgumentException->getMessage());
        }
    }
    
    /**
     * @depends testRouteExists
     */
    public function testControllerExistsForRoute() {        
        $this->assertArrayHasKey(
                self::ROUTER_MATCH_CONTROLLER_KEY,
                $this->getRouter()->match($this->getCurrentRequestUrl($this->getRouteParameters())),
                'No controller found for route [' . $this->getRouteFromTestNamespace() . ']'
        );
    }    
    
    
    /**
     * @depends testControllerExistsForRoute
     */
    public function testRouteHasExpectedController() {
        $this->assertEquals(
                $this->getExpectedRouteController(),
                $this->getRouteController(),
                'Incorrect controller found for route [' . $this->getRouteFromTestNamespace() . '].' . "\n" . 'Expected ' . $this->getExpectedRouteController() . ' got ' . $this->getRouteController() . '.' .  "\n" . 'Check routing.yml default controller for this route.'
        );       

    }
    
    
    /**
     * @depends testRouteHasExpectedController
     */    
    public function testRouteControllerExists() {
        $this->assertTrue(class_exists($this->getControllerNameFromRouter()));      
    }
    
    
    /**
     * @depends testRouteControllerExists
     */        
    public function testRouteControllerActionMethodExists() {
        $className = $this->getControllerNameFromRouter();

        $this->assertTrue(method_exists(new $className(), $this->getActionNameFromRouter()));
    }
    
    
    /**
     * 
     * @return string
     */
    private function getControllerNameFromRouter() {
        return explode('::', $this->getRouteController())[0];
    }
    
    
    /**
     * 
     * @return string
     */
    private function getActionNameFromRouter() {
        return explode('::', $this->getRouteController())[1];
    }
    
    
    
    private function getRouteController() {
        return $this->getRouter()->match($this->getCurrentRequestUrl($this->getRouteParameters()))[self::ROUTER_MATCH_CONTROLLER_KEY];
    }
    
    
    /**
     * 
     * @return string
     */
    protected function getCurrentRequestUrl() {
        return $this->getCurrentController()->generateUrl($this->getRouteFromTestNamespace(), $this->getRouteParameters());
    }
    
    
    /**
     * 
     * @return string
     */
    private function getExpectedRouteController() {
        return $this->getControllerNameFromTestNamespace() . '::' . $this->getActionNameFromTestNamespace();
    }

    
    
    /**
     * 
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    private function getRouter() {
        return $this->client->getContainer()->get('router');        
    }
    
}


