<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Mockery;
use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\EventListener\UserEventListener;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;
use webignition\SimplyTestableUserModel\User;
use webignition\SimplyTestableUserSerializer\UserSerializer;

class UserEventListenerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider onKernelControllerDataProvider
     *
     * @param int $requestType
     * @param string $cookieUser
     * @param string $sessionUser
     * @param string $expectedUser
     */
    public function testOnKernelController($requestType, $cookieUser, $sessionUser, $expectedUser)
    {
        $userEventListener = $this->testServiceProvider->getUserEventListener();
        $userSerializerService = $this->testServiceProvider->getUserSerializer();
        $session = $this->container->get('session');
        $userService = $this->testServiceProvider->getUserService();

        $requestCookies = [];

        if (!empty($cookieUser)) {
            $user = new User($cookieUser, 'password');
            $requestCookies[UserService::USER_COOKIE_KEY] = $userSerializerService->serializeToString($user);
        }

        if (!empty($sessionUser)) {
            $user = new User($sessionUser, 'password');
            $session->set(UserService::SESSION_USER_KEY, $userSerializerService->serialize($user));
        }

        /* @var KernelInterface $kernel */
        $kernel = Mockery::mock(HttpKernelInterface::class);
        $controller = $this->container->get(HomeController::class);
        $request = new Request([], [], [], $requestCookies);
        $callable = [
            $controller,
            'indexAction'
        ];

        $filterControllerEvent = new FilterControllerEvent(
            $kernel,
            $callable,
            $request,
            $requestType
        );

        $userEventListener->onKernelController($filterControllerEvent);

        $this->assertEquals(
            $expectedUser,
            $userService->getUser()->getUsername()
        );
    }

    /**
     * @return array
     */
    public function onKernelControllerDataProvider()
    {
        return [
            'sub request' => [
                'requestType' => HttpKernelInterface::SUB_REQUEST,
                'cookieUser' => null,
                'sessionUser' => null,
                'expectedUser' => 'public',
            ],
            'no user' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'cookieUser' => null,
                'sessionUser' => null,
                'expectedUser' => 'public',
            ],
            'has user in cookie' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'cookieUser' => 'user@example.com',
                'sessionUser' => null,
                'expectedUser' => 'user@example.com',
            ],
            'has user in session' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'cookieUser' => null,
                'sessionUser' => 'user@example.com',
                'expectedUser' => 'user@example.com',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
