<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends BaseController
{
    /**
     * @return RedirectResponse
     */
    public function signOutSubmitAction()
    {
        $this->getUserService()->clearUser();

        $response = $this->redirect($this->generateUrl('home_index', array(), true));
        $response->headers->clearCookie('simplytestable-user', '/', '.simplytestable.com');

        return $response;
    }
}
