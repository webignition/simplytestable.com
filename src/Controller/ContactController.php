<?php

namespace App\Controller;

use App\Model\ContactRequestSubmission;
use App\Request\ContactRequest;
use App\Services\CacheableResponseFactory;
use App\Services\RequestFactory\ContactRequestFactory;
use App\Services\ViewRenderService;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Postmark\PostmarkClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class ContactController
{
    const FLASH_BAG_SEND_STATE_KEY = 'state';
    const FLASH_BAG_SEND_STATE_ERROR = 'error';
    const FLASH_BAG_SEND_STATE_SUCCESS = 'success';
    const FLASH_BAG_SEND_ERROR_STATE_KEY = 'error-state';
    const FLASH_BAG_SEND_ERROR_FIELD_KEY = 'error-field';
    const FLASH_BAG_SEND_STATE_EMPTY = 'empty';
    const FLASH_BAG_SEND_STATE_INVALID = 'invalid';

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ContactRequestFactory
     */
    private $contactRequestFactory;

    public function __construct(
        FlashBagInterface $flashBag,
        RouterInterface $router,
        ContactRequestFactory $contactRequestFactory
    ) {
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->contactRequestFactory = $contactRequestFactory;
    }

    public function renderAction(
        Request $request,
        CacheableResponseFactory $cacheableResponseFactory,
        ViewRenderService $viewRenderService,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response {
        $csrfToken = $csrfTokenManager->getToken(ContactRequest::CSRF_TOKEN_ID);

        $contactRequest = $this->contactRequestFactory->create($csrfToken);
        $contactRequestSubmission = $this->getContactRequestSubmission();

        $viewParameters = [
            'contact_request_submission' => $contactRequestSubmission,
            'contact_request' => $contactRequest,
            'selected_field' => $this->getSelectedField($contactRequest, $contactRequestSubmission),
        ];

        $response = $cacheableResponseFactory->createResponse($request, [
            'cache_key' => (string) json_encode($viewParameters),
        ]);

        if (Response::HTTP_NOT_MODIFIED === $response->getStatusCode()) {
            return $response;
        }

        $response = $viewRenderService->renderResponseWithDefaultViewParameters(
            'contact.html.twig',
            $viewParameters,
            $response
        );

        return $response;
    }

    public function sendAction(
        CsrfTokenManagerInterface $csrfTokenManager,
        PostmarkClient $postmarkClient
    ): RedirectResponse {
        $contactRequest = $this->contactRequestFactory->create();

        if ($contactRequest->isHoneypotSelected()) {
            return $this->createRedirectResponse();
        }

        if (false === $csrfTokenManager->isTokenValid($contactRequest->getCsrfToken())) {
            return $this->createRedirectResponse();
        }

        if (empty($contactRequest->getEmail())) {
            $this->setContactRequestSubmission(
                ContactRequestSubmission::STATE_ERROR,
                ContactRequest::PARAMETER_EMAIL,
                ContactRequestSubmission::ERROR_STATE_EMPTY
            );

            return $this->createRedirectResponse($contactRequest->asArray());
        }

        $emailValidator = new EmailValidator();
        if (!$emailValidator->isValid($contactRequest->getEmail(), new RFCValidation())) {
            $this->setContactRequestSubmission(
                ContactRequestSubmission::STATE_ERROR,
                ContactRequest::PARAMETER_EMAIL,
                ContactRequestSubmission::ERROR_STATE_INVALID
            );

            return $this->createRedirectResponse($contactRequest->asArray());
        }

        if (empty($contactRequest->getMessage())) {
            $this->setContactRequestSubmission(
                ContactRequestSubmission::STATE_ERROR,
                ContactRequest::PARAMETER_MESSAGE,
                ContactRequestSubmission::ERROR_STATE_EMPTY
            );

            return $this->createRedirectResponse($contactRequest->asArray());
        }

        $message = sprintf("From: %s\n\n%s", $contactRequest->getEmail(), $contactRequest->getMessage());

        $postmarkClient->sendEmail(
            'robot@simplytestable.com',
            'support@simplytestable.com',
            'simplytestable.com contact form submission from ' . $contactRequest->getEmail(),
            null,
            $message
        );

        $this->setContactRequestSubmission(ContactRequestSubmission::STATE_SUCCESS);

        return $this->createRedirectResponse();
    }

    private function createRedirectResponse(array $params = []): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('contact_render', array_filter($params)));
    }

    private function getContactRequestSubmission(): ?ContactRequestSubmission
    {
        if (!$this->flashBag->has('contact-request-submission')) {
            return null;
        }

        $contactRequestSubmissionJson = $this->flashBag->get('contact-request-submission')[0];

        return ContactRequestSubmission::fromArray(json_decode($contactRequestSubmissionJson, true));
    }

    private function setContactRequestSubmission(string $state, ?string $errorField = null, ?string $errorState = null)
    {
        $this->flashBag->set('contact-request-submission', json_encode(new ContactRequestSubmission(
            $state,
            $errorField,
            $errorState
        )));
    }

    private function getSelectedField(
        ContactRequest $contactRequest,
        ?ContactRequestSubmission $contactRequestSubmission
    ): string {
        if ($contactRequestSubmission && $contactRequestSubmission->isError()) {
            return $contactRequestSubmission->getErrorField();
        }

        if (empty($contactRequest->getEmail())) {
            return ContactRequest::PARAMETER_EMAIL;
        }

        return $contactRequest::PARAMETER_MESSAGE;
    }
}
