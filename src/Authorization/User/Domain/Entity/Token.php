<?php

namespace App\Authorization\User\Domain\Entity;

use InvalidArgumentException;

class Token
{
    private string $value;
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Token value cannot be empty');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Token $token): bool
    {
        return strcmp($this->value, $token->getValue()) === 0;
    }
}