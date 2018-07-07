<?php

namespace AppBundle\Controller;

use AppBundle\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserController extends AbstractBaseController
{
    /**
     * @return RedirectResponse
     */
    public function signOutSubmitAction()
    {
        $this->userService->clearUser();

        $response = $this->redirect('home_index');
        $response->headers->clearCookie(UserService::USER_COOKIE_KEY, '/', '.simplytestable.com');

        return $response;
    }
}
