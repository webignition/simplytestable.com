<?php

namespace SimplyTestable\WebsiteBundle\Controller;

class OutdatedBrowserController extends CacheableController
{   
    
    public function indexAction() {  
        return $this->renderCacheableResponse();
    }     
}

