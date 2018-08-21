<?php

namespace App\Services;

use webignition\SimplyTestableUserModel\User;

class SystemUserService
{
    const PUBLIC_USER_USERNAME = 'public';
    const PUBLIC_USER_PASSWORD = 'public';

    /**
     * @return User
     */
    public static function getPublicUser()
    {
        return new User(static::PUBLIC_USER_USERNAME, static::PUBLIC_USER_PASSWORD);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public static function isPublicUser(User $user)
    {
        $comparatorUser = new User();
        $comparatorUser->setUsername(strtolower($user->getUsername()));

        return self::getPublicUser()->equals($comparatorUser);
    }
}
