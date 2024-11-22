<?php

namespace App\Authorization\User\Domain\Entity;

use Carbon\Carbon;

class AuthToken
{
    private Token $token;
    private string $userIdentifier;
    private Carbon $expiresAt;

    public function __construct(
        string $token,
        string $userIdentifier,
        Carbon $expiresAt
    ){
        $this->token = new Token($token);
        $this->userIdentifier = $userIdentifier;
        $this->expiresAt = $expiresAt;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function isEqual(AuthToken $token): bool
    {
        return $this->token === $token->getToken();
    }

    public function isExpired(): bool
    {
        return $this->expiresAt->lessThan(Carbon::now());
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }
}