<?php

namespace App\Services;

class DefaultViewParameters
{
    /**
     * @var TestimonialService
     */
    private $testimonialService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var WebClientRouter
     */
    private $webClientRouter;

    public function __construct(
        TestimonialService $testimonialService,
        UserService $userService,
        WebClientRouter $webClientRouter
    ) {
        $this->testimonialService = $testimonialService;
        $this->userService = $userService;
        $this->webClientRouter = $webClientRouter;
    }

    public function getDefaultViewParameters(): array
    {
        return [
            'testimonial' => $this->testimonialService->getRandom(),
            'user' => $this->userService->getUser(),
            'is_logged_in' => $this->userService->isLoggedIn(),
            'web_client_urls' => $this->webClientRouter->generateAll(),
        ];
    }
}
