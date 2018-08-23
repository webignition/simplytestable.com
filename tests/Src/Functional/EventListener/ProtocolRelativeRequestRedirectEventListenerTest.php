<?php

namespace App\Tests\Src\Functional\EventListener;

use App\EventListener\ProtocolRelativeRequestRedirectEventListener;
use App\Tests\Src\Functional\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class ProtocolRelativeRequestRedirectEventListenerTest extends AbstractWebTestCase
{
    /**
     * @var ProtocolRelativeRequestRedirectEventListener
     */
    private $eventListener;

    protected function setUp()
    {
        parent::setUp();

        $this->eventListener = self::$container->get(ProtocolRelativeRequestRedirectEventListener::class);
    }

    /**
     * @dataProvider onKernelExceptionNullResponseDataProvider
     *
     * @param Request $request
     * @param int $requestType
     * @param \Exception $exception
     */
    public function testOnKernelExceptionNullResponse(Request $request, int $requestType, \Exception $exception)
    {
        $event = $this->createGetResponseForExceptionEvent($request, $exception, $requestType);
        $this->eventListener->onKernelException($event);

        $this->assertFalse($event->hasResponse());
    }

    /**
     * @return array
     */
    public function onKernelExceptionNullResponseDataProvider()
    {
        return [
            'sub request' => [
                'request' => new Request(),
                'requestType' => KernelInterface::SUB_REQUEST,
                'exception' => new \Exception(),
            ],
            'not NotFoundHttpException' => [
                'request' => new Request(),
                'requestType' => KernelInterface::MASTER_REQUEST,
                'exception' => new \Exception(),
            ],
            'not protocol-relative url as request path' => [
                'request' => new Request([], [], [], [], [], [
                    'REQUEST_URI' => '/foo'
                ]),
                'requestType' => KernelInterface::MASTER_REQUEST,
                'exception' => new NotFoundHttpException(),
            ],
            'protocol-relative url as request path, invalid host' => [
                'request' => new Request([], [], [], [], [], [
                    'REQUEST_URI' => '//example.com/foo'
                ]),
                'requestType' => KernelInterface::MASTER_REQUEST,
                'exception' => new NotFoundHttpException(),
            ],
        ];
    }

    public function testOnKernelExceptionResponseIsSet()
    {
        $event = $this->createGetResponseForExceptionEvent(
            new Request([], [], [], [], [], [
                'REQUEST_URI' => '//simplytestable.com/plans'
            ]),
            new NotFoundHttpException()
        );

        $this->eventListener->onKernelException($event);

        $this->assertTrue($event->hasResponse());

        /* @var RedirectResponse $response */
        $response = $event->getResponse();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('http://simplytestable.com/plans', $response->getTargetUrl());
    }

    /**
     * @param Request $request
     * @param \Exception $exception
     * @param int $requestType
     *
     * @return GetResponseForExceptionEvent
     */
    private function createGetResponseForExceptionEvent(
        Request $request,
        \Exception $exception,
        int $requestType = KernelInterface::MASTER_REQUEST
    ) {
        $kernel = self::$container->get(KernelInterface::class);

        return new GetResponseForExceptionEvent($kernel, $request, $requestType, $exception);
    }
}
