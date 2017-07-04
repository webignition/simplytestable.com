<?php

namespace Tests\WebsiteBundle\Functional\Controller;

use SimplyTestable\WebsiteBundle\Controller\HomeController;
use SimplyTestable\WebsiteBundle\Model\User;
use SimplyTestable\WebsiteBundle\Services\UserService;
use Tests\WebsiteBundle\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class UserEventListenerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider onKernelRequestDataProvider
     *
     * @param int $requestType
     * @param array $requestAttributes
     * @param string $requestUser
     * @param string $expectedUser
     */
    public function testOnKernelRequest($requestType, $requestAttributes, $requestUser, $expectedUser)
    {
        $userEventListener = $this->container->get('simplytestable.eventlistener.user');

        $requestCookies = [];

        if (!empty($requestUser)) {
            $user = new User();
            $user->setUsername($requestUser);

            $userSerializerService = $this->container->get('simplytestable.services.userserializerservice');
            $serializedUser = $userSerializerService->serializeToString($user);

            $requestCookies[UserService::USER_COOKIE_KEY] = $serializedUser;
        }

        $request = new Request([], [], $requestAttributes, $requestCookies);

        $kernelEvent = new KernelEvent(
            $this->container->get('kernel'),
            $request,
            $requestType
        );

        $userEventListener->onKernelRequest($kernelEvent);

        $this->assertEquals(
            $expectedUser,
            $this->container->get('simplytestable.services.userservice')->getUser()->getUsername()
        );
    }

    /**
     * @return array
     */
    public function onKernelRequestDataProvider()
    {
        return [
            'sub request' => [
                'requestType' => HttpKernelInterface::SUB_REQUEST,
                'requestAttributes' => [],
                'requestUser' => null,
                'expectedUser' => 'public',
            ],
            'no controller in request attributes' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [],
                'requestUser' => null,
                'expectedUser' => 'public',
            ],
            'no user' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestUser' => null,
                'expectedUser' => 'public',
            ],
            'has user' => [
                'requestType' => HttpKernelInterface::MASTER_REQUEST,
                'requestAttributes' => [
                    '_controller' => sprintf('%s::indexAction', HomeController::class),
                ],
                'requestUser' => 'user@example.com',
                'expectedUser' => 'user@example.com',
            ],
        ];
    }
}
