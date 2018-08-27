<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SimplyTestable\PageCacheBundle\Services\CacheableResponseFactory as BaseCacheableResponseFactory;

class CacheableResponseFactory
{
    /**
     * @var BaseCacheableResponseFactory
     */
    private $baseCacheableResponseFactory;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        BaseCacheableResponseFactory $baseCacheableResponseFactory,
        UserService $userService
    ) {
        $this->baseCacheableResponseFactory = $baseCacheableResponseFactory;
        $this->userService = $userService;
    }

    public function createResponse(Request $request, array $parameters): Response
    {
        $user = $this->userService->getUser();

        $userParameters = [
            'user' => $user->getUsername(),
            'is_logged_in' => $this->userService->isLoggedIn(),
        ];

        return $this->baseCacheableResponseFactory->createResponse(
            $request,
            array_merge($userParameters, $parameters)
        );
    }
}
