<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use Mockery;
use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\Model\User;
use SimplyTestable\WebsiteBundle\Services\UserSerializerService;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;

class UserEventListenerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider onKernelControllerDataProvider
     *
     * @param int $requestType
     * @param string $requestUser
     * @param string $expectedUser
     */
    public function testOnKernelController($requestType, $requestUser, $expectedUser)
    {
        $userEventListener = $this->container->get('simplytestable.eventlistener.user');

        $requestCookies = [];

        if (!empty($requestUser)) {
            $user = new User();
            $user->setUsername($requestUser);

            $userSerializerService = $this->container->get(UserSerializerService::class);
            $serializedUser = $userSerializerService->serializeToString($user);

            $requestCookies[UserService::USER_COOKIE_KEY] = $serializedUser;
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
            $this->container->get(UserService::class)->getUser()->getUsername()
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
                'requestUser' => null,
                'expectedUser' => 'public',
            ],
            'no user' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestUser' => null,
                'expectedUser' => 'public',
            ],
            'has user' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestUser' => 'user@example.com',
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
