<?php

namespace App\Request;

use Symfony\Component\Security\Csrf\CsrfToken;

class ContactRequest implements \JsonSerializable
{
    const PARAMETER_EMAIL = 'email';
    const PARAMETER_MESSAGE = 'message';
    const PARAMETER_CSRF_TOKEN = 'token';
    const CSRF_TOKEN_ID = 'contact-send';

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $message;

    /**
     * @var CsrfToken
     */
    private $csrfToken;

    public function __construct(string $email, string $message, string $csrfToken)
    {
        $this->email = $email;
        $this->message = $message;
        $this->csrfToken = new CsrfToken(self::CSRF_TOKEN_ID, $csrfToken);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCsrfToken(): CsrfToken
    {
        return $this->csrfToken;
    }

    public function asArray(): array
    {
        return [
            self::PARAMETER_EMAIL => $this->email,
            self::PARAMETER_MESSAGE => $this->message,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->asArray();
    }
}
