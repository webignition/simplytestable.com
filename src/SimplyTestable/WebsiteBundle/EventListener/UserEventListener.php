<?php

namespace SimplyTestable\WebsiteBundle\EventListener;

use SimplyTestable\WebsiteBundle\Services\UserService;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class UserEventListener
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param KernelEvent $event
     */
    public function onKernelRequest(KernelEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $controllerActionParts = explode('::', $request->attributes->get('_controller'));
        $isApplicationControllerRequest = class_exists($controllerActionParts[0]);

        if ($isApplicationControllerRequest) {
            $this->userService->setUserFromRequest($request);
        }
    }
}
