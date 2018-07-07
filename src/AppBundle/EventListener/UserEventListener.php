<?php

namespace AppBundle\EventListener;

use AppBundle\Controller\AbstractBaseController;
use AppBundle\Services\UserService;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

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
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $controller = $event->getController()[0];

        if ($controller instanceof AbstractBaseController) {
            $this->userService->setUserFromRequest($request);
        }
    }
}