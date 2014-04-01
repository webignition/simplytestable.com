<?php

namespace SimplyTestable\WebsiteBundle\Tests\Controller\DefaultController;

use SimplyTestable\WebsiteBundle\Tests\Controller\ActionTest as BaseActionTest;

abstract class ActionTest extends BaseActionTest {
    
    protected function getActionName() {
        $classNameParts = explode('\\', get_class($this));
        
        foreach ($classNameParts as $classNamePart) {
            if (preg_match('/.+Action/', $classNamePart)) {
                return $classNamePart;
            }
        }
    }
    
    protected function getControllerName() {
        return self::DEFAULT_CONTROLLER_NAME;
    }   
}
