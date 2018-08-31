<?php

namespace App\Model;

class ContactRequestSubmission implements \JsonSerializable
{
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';
    const ERROR_STATE_EMPTY = 'empty';
    const ERROR_STATE_INVALID = 'invalid';

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $errorField;

    /**
     * @var string
     */
    private $errorState;

    public function __construct(string $state, ?string $errorField = null, ?string $errorState = null)
    {
        $this->state = $state;
        $this->errorField = $errorField;
        $this->errorState = $errorState;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function isError(): bool
    {
        return self::STATE_ERROR === $this->state;
    }

    public function getErrorField(): ?string
    {
        return $this->errorField;
    }

    public function getErrorState(): ?string
    {
        return $this->errorState;
    }

    public function jsonSerialize(): array
    {
        return [
            'state' => $this->state,
            'error_field' => $this->errorField,
            'error_state' => $this->errorState,
        ];
    }

    public static function fromArray(array $values): ContactRequestSubmission
    {
        return new ContactRequestSubmission(
            $values['state'],
            $values['error_field'],
            $values['error_state']
        );
    }
}
