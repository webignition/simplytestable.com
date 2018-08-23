<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use webignition\Url\Url;

class ProtocolRelativeRequestRedirectEventListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return null;
        }

        $exception = $event->getException();

        if (!$exception instanceof NotFoundHttpException) {
            return null;
        }

        $urlPath = $event->getRequest()->getPathInfo();
        $urlPathObject = new Url($urlPath);

        if ($urlPathObject->isProtocolRelative() && preg_match('/.*simplytestable.com$/', $urlPathObject->getHost())) {
            $event->setResponse(new RedirectResponse(
                'http:' . $urlPath
            ));
        }

        return null;
    }
}
