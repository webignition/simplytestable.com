<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use SimplyTestable\WebsiteBundle\Interfaces\Controller\Cacheable;

class OutdatedBrowserController extends BaseController implements Cacheable
{   
    
    public function indexAction() {  
        return $this->renderCacheableResponse();
    }     
}

