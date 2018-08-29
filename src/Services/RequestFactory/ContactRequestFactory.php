<?php

namespace App\Services\RequestFactory;

use App\Request\ContactRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ContactRequestFactory
{
    /**
     * @var ParameterBag
     */
    private $requestParameters;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $this->requestParameters = Request::METHOD_GET === $request->getMethod()
            ? $request->query
            : $request->request;
    }

    public function create(): ContactRequest
    {
        return new ContactRequest(
            $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_EMAIL),
            $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_MESSAGE),
            $this->getStringValueFromRequestParameters(ContactRequest::PARAMETER_CSRF_TOKEN)
        );
    }

    private function getStringValueFromRequestParameters(string $key): string
    {
        return trim($this->requestParameters->get($key));
    }
}
