<?php

namespace App\Controller;

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
    const FLASH_BAG_SEND_MESSAGE_KEY = 'message';
    const FLASH_BAG_SEND_MESSAGE_EMAIL_EMPTY = 'email-empty';
    const FLASH_BAG_SEND_MESSAGE_EMAIL_INVALID = 'email-invalid';
    const FLASH_BAG_SEND_MESSAGE_MESSAGE_EMPTY = 'message-empty';


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
        ViewRenderService $viewRenderService
    ): Response {
        $contactRequest = $this->contactRequestFactory->create();

        $sendState = $this->getFlashValue(self::FLASH_BAG_SEND_STATE_KEY);
        $sendMessage = $this->getFlashValue(self::FLASH_BAG_SEND_MESSAGE_KEY);

        $response = $cacheableResponseFactory->createResponse($request, array_merge(
            $contactRequest->asArray(),
            [
                'send_state' => $sendState,
                'send_message' => $sendMessage,
            ]
        ));

        if (Response::HTTP_NOT_MODIFIED === $response->getStatusCode()) {
            return $response;
        }

        $response = $viewRenderService->renderResponseWithDefaultViewParameters(
            'contact.html.twig',
            [
                'send_state' => $sendState,
                'send_message' => $sendMessage,
                'contact_request' => $contactRequest,
            ],
            $response
        );

        return $response;
    }

    public function sendAction(
        CsrfTokenManagerInterface $csrfTokenManager,
        PostmarkClient $postmarkClient
    ): RedirectResponse {
        $contactRequest = $this->contactRequestFactory->create();

        if (false === $csrfTokenManager->isTokenValid($contactRequest->getCsrfToken())) {
            return $this->createRedirectResponse();
        }

        if (empty($contactRequest->getEmail())) {
            $this->flashBag->set(
                self::FLASH_BAG_SEND_STATE_KEY,
                self::FLASH_BAG_SEND_STATE_ERROR
            );

            $this->flashBag->set(
                self::FLASH_BAG_SEND_MESSAGE_KEY,
                self::FLASH_BAG_SEND_MESSAGE_EMAIL_EMPTY
            );

            return $this->createRedirectResponse($contactRequest->asArray());
        }

        $emailValidator = new EmailValidator();
        if (!$emailValidator->isValid($contactRequest->getEmail(), new RFCValidation())) {
            $this->flashBag->set(
                self::FLASH_BAG_SEND_STATE_KEY,
                self::FLASH_BAG_SEND_STATE_ERROR
            );

            $this->flashBag->set(
                self::FLASH_BAG_SEND_MESSAGE_KEY,
                self::FLASH_BAG_SEND_MESSAGE_EMAIL_INVALID
            );

            return $this->createRedirectResponse($contactRequest->asArray());
        }

        if (empty($contactRequest->getMessage())) {
            $this->flashBag->set(
                self::FLASH_BAG_SEND_STATE_KEY,
                self::FLASH_BAG_SEND_STATE_ERROR
            );

            $this->flashBag->set(
                self::FLASH_BAG_SEND_MESSAGE_KEY,
                self::FLASH_BAG_SEND_MESSAGE_MESSAGE_EMPTY
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

        $this->flashBag->set(
            self::FLASH_BAG_SEND_STATE_KEY,
            self::FLASH_BAG_SEND_STATE_SUCCESS
        );

        return $this->createRedirectResponse();
    }

    private function createRedirectResponse(array $params = []): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('contact_render', array_filter($params)));
    }

    private function getFlashValue(string $key): string
    {
        if (!$this->flashBag->has($key)) {
            return '';
        }

        return $this->flashBag->get($key)[0];
    }
}
