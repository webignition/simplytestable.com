<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionLoggerEventListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return null;
        }

        $exception = $event->getException();

        $messagePrefix = $exception instanceof NotFoundHttpException
            ? 'HTTP404'
            : 'HTTP500';

        $this->logger->error($messagePrefix . ':' . $exception->getMessage(), [
            'http-user-agent' => $event->getRequest()->headers->get('user-agent'),
        ]);

        return null;
    }
}
