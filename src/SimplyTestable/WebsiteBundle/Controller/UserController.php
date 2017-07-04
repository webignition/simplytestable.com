<?php

namespace SimplyTestable\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserController extends AbstractBaseController
{
    /**
     * @return RedirectResponse
     */
    public function signOutSubmitAction()
    {
        $this->getUserService()->clearUser();

        $response = $this->redirect($this->generateUrl('home_index', array(), UrlGeneratorInterface::ABSOLUTE_URL));
        $response->headers->clearCookie('simplytestable-user', '/', '.simplytestable.com');

        return $response;
    }
}
