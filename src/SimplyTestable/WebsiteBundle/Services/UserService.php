<?php

namespace SimplyTestable\WebsiteBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\InvalidCipherTextException;
use webignition\SimplyTestableUserSerializer\UserSerializer;

class UserService
{
    const USER_COOKIE_KEY = 'simplytestable-user';
    const SESSION_USER_KEY = 'user';

    const PUBLIC_USER_USERNAME = 'public';
    const PUBLIC_USER_PASSWORD = 'public';

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
     * @return User
     */
    public function getPublicUser()
    {
        return new User(static::PUBLIC_USER_USERNAME, static::PUBLIC_USER_PASSWORD);
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function isPublicUser(User $user)
    {
        $comparatorUser = new User();
        $comparatorUser->setUsername(strtolower($user->getUsername()));

        return $this->getPublicUser()->equals($comparatorUser);
    }

    /**
     * @return boolean
     */
    public function isLoggedIn()
    {
        return !$this->isPublicUser($this->getUser());
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
            $this->setUser($this->getPublicUser());
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
            $user = $this->getPublicUser();
        }

        $this->setUser($user);

        return;
    }
}
