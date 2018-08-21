<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use webignition\SimplyTestableUserHydrator\UserHydrator;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\UserSerializer;

class UserService
{
    const USER_COOKIE_KEY = 'simplytestable-user';
    const SESSION_USER_KEY = 'user';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var UserSerializer
     */
    private $userSerializer;

    /**
     * @var User
     */
    private $user;

    public function __construct(SessionInterface $session, UserSerializer $userSerializer, UserHydrator $userHydrator)
    {
        $this->session = $session;
        $this->userSerializer = $userSerializer;

        $user = $userHydrator->getUser();

        if (empty($user)) {
            $user = SystemUserService::getPublicUser();
        }

        $this->user = $user;
        $this->session->set(self::SESSION_USER_KEY, $this->userSerializer->serialize($user));
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return false === SystemUserService::isPublicUser($this->user);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function clearUser()
    {
        $this->session->remove(self::SESSION_USER_KEY);
    }
}
