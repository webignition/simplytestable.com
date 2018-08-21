<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\InvalidCipherTextException;
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
     * @param SessionInterface $session
     * @param UserSerializer $userSerializer
     */
    public function __construct(
        SessionInterface $session,
        UserSerializer $userSerializer
    ) {
        $this->session = $session;
        $this->userSerializer = $userSerializer;
    }

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        return false === SystemUserService::isPublicUser($this->getUser());
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->session->set('user', $this->userSerializer->serialize($user));
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (is_null($this->session->get('user'))) {
            $this->setUser(SystemUserService::getPublicUser());
        }

        return $this->userSerializer->deserialize($this->session->get('user'));
    }

    public function clearUser()
    {
        $this->session->set('user', null);
    }

    /**
     * @param Request $request
     *
     * @return null
     */
    public function setUserFromRequest(Request $request)
    {
        $user = null;

        if ($request->cookies->has(self::USER_COOKIE_KEY)) {
            try {
                $user = $this->userSerializer->deserializeFromString(
                    $request->cookies->get(self::USER_COOKIE_KEY)
                );
            } catch (InvalidCipherTextException $invalidHmacException) {
            }
        }

        if (empty($user)) {
            $sessionUser = $this->session->get(self::SESSION_USER_KEY);

            if (!empty($sessionUser)) {
                try {
                    $user = $this->userSerializer->deserialize($sessionUser);
                } catch (InvalidCipherTextException $invalidHmacException) {
                }
            }
        }

        if (empty($user)) {
            $user = SystemUserService::getPublicUser();
        }

        $this->setUser($user);

        return;
    }
}
