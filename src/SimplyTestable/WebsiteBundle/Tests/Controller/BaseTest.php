<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller;

use SimplyTestable\WebsiteBundle\Tests\BaseSimplyTestableTestCase;

abstract class BaseTest extends BaseSimplyTestableTestCase {
      
    public function setUp() {
        parent::setUp();
        $this->container->enterScope('request');        
    }
    
    protected function getControllerName() {
        return $this->getControllerNameFromTestNamespace();
    }
    
    protected function getActionName() {        
        return $this->getActionNameFromTestNamespace();
    }
    
    protected function getCurrentController($postData = null, $queryData = null) {
        $postData = (is_array($postData)) ? $postData : array();
        $queryData = (is_array($queryData)) ? $queryData : array();
        
        return $this->getController(
            $this->getControllerName(),
            $this->getActionName(),
            $this->getRouteFromTestNamespace(),
            $postData,
            $queryData
        );
    }
    

    /**
     * 
     * @return string
     */
    protected function getControllerNameFromTestNamespace() {        
        $testNamespaceParts = $this->getTestNamespaceParts();
        $nonActionNamespaceParts = array_slice($testNamespaceParts, 0, array_search(ucfirst($this->getActionName()), $testNamespaceParts));        
        
        return str_replace('\Tests\\', '\\', implode('\\', $nonActionNamespaceParts) . 'Controller');
    }
    
    
    /**
     * Get controller action from current test namespace
     * 
     * @return string
     */
    protected function getActionNameFromTestNamespace() {
        foreach ($this->getTestNamespaceParts() as $part) {
            if (preg_match('/.+Action$/', $part)) {
                return lcfirst($part);
            }
        }
    }
    
    
    /**
     * Get route name for current test
     * 
     * Is extracted from the class namespace as follows:
     * \Acme\FooBundle\Tests\Controller\Foo => 'foo'
     * \Acme\FooBundle\Tests\Controller\FooBar => 'foo_bar'
     * \Acme\FooBundle\Tests\Controller\FooBar\Bar => 'foobar_bar'
     * 
     * @return string
     */
    protected function getRouteFromTestNamespace() {   
        return strtolower(implode('_', $this->getControllerRelatedNamespaceParts()) . '_' . str_replace('Action', '', $this->getActionNameFromTestNamespace())); 
    }    
    

    /**
     * 
     * @return string[]
     */    
    private function getControllerRelatedNamespaceParts() {
        $parts = $this->getControllerNamespaceParts();

        foreach ($parts as $index => $part) {
            if ($part === 'Controller') {
                return array_slice($parts, $index + 1);
            }
        }
        
        return $parts;         
        
//        $testNamespaceParts = $this->getTestNamespaceParts();        
//        return array_slice($testNamespaceParts, array_search('Controller', $testNamespaceParts) + 1);
    }
    
    
    /**
     * 
     * @return string[]
     */
    private function getControllerNamespaceParts() {
        $relevantParts = array();
        
        foreach ($this->getTestNamespaceParts() as $part) {
            if (preg_match('/.+Action$/', $part)) {
                return $relevantParts;
            }
            
            if ($part != 'Tests') {
                $relevantParts[] = $part;
            }
        }
        
        return $relevantParts;       
    }    
    
    
    /**
     * 
     * @return string[]
     */
    private function getTestNamespaceParts() {
        return explode('\\', get_class($this));
    }

}
