<?php

namespace SimplyTestable\WebsiteBundle\Controller;

class UserController extends BaseController
{     
    public function signOutSubmitAction() {
        $this->getUserService()->clearUser();
        
        $response = $this->redirect($this->generateUrl('home_index', array(), true)); 
        $response->headers->clearCookie('simplytestable-user', '/', '.simplytestable.com');
        
        return $response;    
    }
}
