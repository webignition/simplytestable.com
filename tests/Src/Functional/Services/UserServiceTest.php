<?php

namespace App\Tests\Src\Functional\Services;

use App\Services\SystemUserService;
use App\Services\UserService;
use App\Tests\Src\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use webignition\SimplyTestableUserHydrator\UserHydrator;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\UserSerializer;

class UserServiceTest extends AbstractWebTestCase
{
    const USER_EMAIL = 'user@example.com';
    const USER_PASSWORD = 'password';

    /**
     * @dataProvider getUserIsLoggedInDataProvider
     *
     * @param Request $request
     * @param User|null $sessionUser
     * @param User $expectedUser
     * @param bool $expectedIsLoggedIn
     */
    public function testGetUserIsLoggedIn(Request $request, $sessionUser, User $expectedUser, bool $expectedIsLoggedIn)
    {
        $userService = $this->createUserService($request, $sessionUser, $expectedUser);

        $this->assertEquals($expectedUser, $userService->getUser());
        $this->assertEquals($expectedIsLoggedIn, $userService->isLoggedIn());
    }

    /**
     * @return array
     */
    public function getUserIsLoggedInDataProvider()
    {
        $publicUser = SystemUserService::getPublicUser();
        $privateUser = new User(self::USER_EMAIL, self::USER_PASSWORD);

        return [
            'no user in request' => [
                'request' => new Request(),
                'sessionUser' => null,
                'expectedUser' => $publicUser,
                'expectedIsLoggedIn' => false,
            ],
            'invalid user in request, no user in session' => [
                'request' => new Request([], [], [], [
                    UserService::USER_COOKIE_KEY => false,
                ]),
                'sessionUser' => null,
                'expectedUser' => $publicUser,
                'expectedIsLoggedIn' => false,
            ],
            'valid user in session' => [
                'request' => new Request(),
                'sessionUser' => $privateUser,
                'expectedUser' => $privateUser,
                'expectedIsLoggedIn' => true,
            ],
            'valid user in request, no user in session' => [
                'request' => new Request([], [], [], [
                    UserService::USER_COOKIE_KEY => true,
                ]),
                'sessionUser' => null,
                'expectedUser' => $privateUser,
                'expectedIsLoggedIn' => true,
            ],
        ];
    }



    public function testClearUser()
    {
        $session = self::$container->get(SessionInterface::class);
        $userSerializer = self::$container->get(UserSerializer::class);
        $userService = self::$container->get(UserService::class);

        $user = new User(self::USER_EMAIL, self::USER_PASSWORD);
        $session->set(UserService::SESSION_USER_KEY, $userSerializer->serialize($user));

        $this->assertTrue($session->has(UserService::SESSION_USER_KEY));

        $userService->clearUser();

        $this->assertFalse($session->has(UserService::SESSION_USER_KEY));
    }

    /**
     * @param Request $request
     * @param User|null $sessionUser
     * @param User|null $cookieUser
     *
     * @return UserService
     */
    private function createUserService(Request $request, $sessionUser = null, $cookieUser = null)
    {
        $requestStack = self::$container->get(RequestStack::class);
        $session = self::$container->get(SessionInterface::class);
        $userSerializer = self::$container->get(UserSerializer::class);

        if ($request->cookies->has(UserService::USER_COOKIE_KEY)) {
            $request->cookies->set(UserService::USER_COOKIE_KEY, $userSerializer->serializeToString($cookieUser));
        }

        $requestStack->push($request);

        if (!empty($sessionUser)) {
            $session->set(UserService::SESSION_USER_KEY, $userSerializer->serialize($sessionUser));
        }

        $userHydrator = new UserHydrator($requestStack, $userSerializer, $session);

        return new UserService(
            $session,
            $userSerializer,
            $userHydrator
        );
    }
}
