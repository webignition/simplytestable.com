<?php
namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UserService
{
    const USER_COOKIE_KEY = 'simplytestable-user';

    const PUBLIC_USER_USERNAME = 'public';
    const PUBLIC_USER_PASSWORD = 'public';

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserSerializerService
     */
    private $userSerializerService;

    /**
     * @param Session $session
     * @param UserSerializerService $userSerializerService
     */
    public function __construct(
        Session $session,
        UserSerializerService $userSerializerService
    ) {
        $this->session = $session;
        $this->userSerializerService = $userSerializerService;
    }

    /**
     * @return User
     */
    public function getPublicUser()
    {
        $user = new User();
        $user->setUsername(static::PUBLIC_USER_USERNAME);
        $user->setPassword(static::PUBLIC_USER_PASSWORD);
        return $user;
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
        $this->session->set('user', $this->userSerializerService->serialize($user));
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (is_null($this->session->get('user'))) {
            $this->setUser($this->getPublicUser());
        }

        return $this->userSerializerService->unserialize($this->session->get('user'));
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
        if (!$request->cookies->has(self::USER_COOKIE_KEY)) {
            $this->setUser($this->getPublicUser());
            return;
        }

        $user = $this->userSerializerService->unserializedFromString($request->cookies->get(self::USER_COOKIE_KEY));

        if (is_null($user)) {
            return;
        }

        $this->setUser($user);
    }
}
