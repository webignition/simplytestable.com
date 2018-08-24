<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use webignition\IEDetector\IEDetector;

class IEFilteredRequestListener
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(RouterInterface $router, LoggerInterface $logger)
    {
        $this->router = $router;
        $this->logger = $logger;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (Request::METHOD_GET !== $request->getMethod()) {
            return;
        }

        $userAgentString = $request->headers->get('user-agent');
        if (empty($userAgentString)) {
            $userAgentString = $request->server->get('HTTP_USER_AGENT');
        }

        if (empty($userAgentString)) {
            return;
        }

        $isUsingOldIE =
            IEDetector::isIE6($userAgentString) ||
            IEDetector::isIE7($userAgentString) ||
            IEDetector::isIE8($userAgentString) ||
            IEDetector::isIE9($userAgentString);

        if ($isUsingOldIE) {
            $this->logger->error(sprintf(
                'Detected old IE for [%s]',
                $userAgentString
            ));

            $event->setResponse(new RedirectResponse($this->router->generate('outdatedbrowser_index')));
        }
    }
}
