<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class UserController
{
    public function signOutSubmitAction(UserService $userService, RouterInterface $router): RedirectResponse
    {
        $userService->clearUser();

        $response = new RedirectResponse($router->generate('home_index'));
        $response->headers->clearCookie(UserService::USER_COOKIE_KEY, '/', '.simplytestable.com');

        return $response;
    }
}
