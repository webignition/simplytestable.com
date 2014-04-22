<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\PlanDetails\IndexAction\ActionTest;

abstract class ActionTest extends \SimplyTestable\WebsiteBundle\Tests\Controller\ActionTest {

    protected function getExpectedResponseStatusCode() {
        return 200;
    }
    
    protected function getActionMethodArguments() {
        return array(
            'name' => $this->getPlanNameFromTestName()
        );
    }
    
    
    private function getPlanNameFromTestName() {
        $classNameParts = explode('\\', get_class($this));        
        return strtolower(str_replace('Test', '', $classNameParts[count($classNameParts) - 1]));       
    }
}