<?php

namespace App\Request;

use Symfony\Component\Security\Csrf\CsrfToken;

class ContactRequest implements \JsonSerializable
{
    const PARAMETER_EMAIL = 'email';
    const PARAMETER_MESSAGE = 'message';
    const PARAMETER_CSRF_TOKEN = 'token';
    const CSRF_TOKEN_ID = 'contact-send';
    const PARAMETER_HONEYPOT = 'hp';

    private $email;
    private $message;
    private $csrfToken;
    private $isHoneypotSelected;

    public function __construct(string $email, string $message, string $csrfToken, bool $isHoneypotSelected)
    {
        $this->email = $email;
        $this->message = $message;
        $this->csrfToken = new CsrfToken(self::CSRF_TOKEN_ID, $csrfToken);
        $this->isHoneypotSelected = $isHoneypotSelected;
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

    public function isHoneypotSelected(): bool
    {
        return $this->isHoneypotSelected;
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
