<?php

namespace App\Tests\Src\Unit\Services;

use App\Services\SystemUserService;
use webignition\SimplyTestableUserModel\User;

class SystemUserServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetPublicUser()
    {
        $publicUser = SystemUserService::getPublicUser();

        $this->assertInstanceOf(User::class, $publicUser);
        $this->assertEquals(SystemUserService::PUBLIC_USER_USERNAME, $publicUser->getUsername());
        $this->assertEquals(SystemUserService::PUBLIC_USER_PASSWORD, $publicUser->getPassword());
    }

    /**
     * @dataProvider isPublicUserDataProvider
     *
     * @param User $user
     * @param bool $expectedIsPublicUser
     */
    public function testIsPublicUser(User $user, bool $expectedIsPublicUser)
    {
        $this->assertEquals($expectedIsPublicUser, SystemUserService::isPublicUser($user));
    }

    /**
     * @return array
     */
    public function isPublicUserDataProvider()
    {
        return [
            'not public user' => [
                'user' => new User(),
                'expectedIsPublicUser' => false,
            ],
            'is public user' => [
                'user' => SystemUserService::getPublicUser(),
                'expectedIsPublicUser' => true,
            ],
        ];
    }
}
