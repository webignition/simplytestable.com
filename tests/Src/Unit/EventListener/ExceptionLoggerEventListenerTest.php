<?php

namespace App\Tests\Src\Unit\Services;

use App\EventListener\ExceptionLoggerEventListener;
use LogicException;
use Mockery\MockInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionLoggerEventListenerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider onKernelExceptionDataProvider
     *
     * @param LoggerInterface $logger
     * @param GetResponseForExceptionEvent $event
     */
    public function testOnKernelException(LoggerInterface $logger, GetResponseForExceptionEvent $event)
    {
        $eventListener = new ExceptionLoggerEventListener($logger);

        $this->assertNull($eventListener->onKernelException($event));
    }

    public function onKernelExceptionDataProvider(): array
    {
        return [
            'sub request' => [
                'logger' => \Mockery::mock(LoggerInterface::class),
                'event' => $this->createGetResponseForExceptionEvent(
                    new Request(),
                    KernelInterface::SUB_REQUEST,
                    new \Exception()
                )
            ],
            'NotFoundHttpException' => [
                'logger' => $this->createLogger([
                    'HTTP404:No route found for "GET /foo"',
                    [
                        'http-user-agent' => 'Foo User Agent',
                    ],
                ]),
                'event' => $this->createGetResponseForExceptionEvent(
                    $this->createRequest([
                        'User-Agent' => 'Foo User Agent',
                    ]),
                    KernelInterface::MASTER_REQUEST,
                    new NotFoundHttpException(
                        'No route found for "GET /foo"'
                    )
                )
            ],
            'LogicException' => [
                'logger' => $this->createLogger([
                    'HTTP500:Invalid operation',
                    [
                        'http-user-agent' => 'Foo User Agent',
                    ],
                ]),
                'event' => $this->createGetResponseForExceptionEvent(
                    $this->createRequest([
                        'User-Agent' => 'Foo User Agent',
                    ]),
                    KernelInterface::MASTER_REQUEST,
                    new LogicException(
                        'Invalid operation'
                    )
                )
            ],
        ];
    }

    private function createGetResponseForExceptionEvent(
        Request $request,
        int $requestType,
        \Exception $exception
    ): GetResponseForExceptionEvent {
        /* @var MockInterface|KernelInterface $kernel */
        $kernel = \Mockery::mock(KernelInterface::class);

        return new GetResponseForExceptionEvent($kernel, $request, $requestType, $exception);
    }

    private function createRequest(array $headers): Request
    {
        $request = new Request();
        $request->headers->replace($headers);

        return $request;
    }

    /**
     * @param array|callable $errorArgs
     *
     * @return MockInterface|LoggerInterface
     */
    private function createLogger($errorArgs)
    {
        $logger = \Mockery::mock(LoggerInterface::class);

        $logger
            ->shouldReceive('error')
            ->withArgs($errorArgs);

        return $logger;
    }
}
