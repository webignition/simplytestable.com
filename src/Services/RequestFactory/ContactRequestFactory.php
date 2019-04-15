<?php

namespace App\Services\RequestFactory;

use App\Request\ContactRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfToken;

class ContactRequestFactory
{
    /**
     * @var ParameterBag
     */
    private $requestParameters;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(RequestStack $requestStack, UserService $userService)
    {
        $request = $requestStack->getCurrentRequest();

        $this->requestParameters = Request::METHOD_GET === $request->getMethod()
            ? $request->query
            : $request->request;

        $this->userService = $userService;
    }

    public function create(?CsrfToken $csrfToken = null): ContactRequest
    {
        $email = $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_EMAIL);

        if ($this->userService->isLoggedIn()) {
            $user = $this->userService->getUser();
            $email = $user->getUsername();
        }

        $csrfTokenValue = null === $csrfToken
            ? $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_CSRF_TOKEN)
            : $csrfToken->getValue();

        return new ContactRequest(
            $email,
            $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_MESSAGE),
            $csrfTokenValue
        );
    }

    private function getStringValueFromRequestParameters(string $key): string
    {
        return trim($this->requestParameters->get($key));
    }
}
