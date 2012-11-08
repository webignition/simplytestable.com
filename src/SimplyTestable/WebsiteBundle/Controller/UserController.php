<?php

namespace SimplyTestable\WebsiteBundle\Controller;

class UserController extends BaseController
{     
    public function signOutSubmitAction() {
        $this->getUserService()->clearUser();
        return $this->redirect($this->generateUrl('homepage', array(), true));        
    }
}
