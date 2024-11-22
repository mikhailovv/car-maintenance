<?php

namespace App\Authorization\User\Domain\Entity;

class HashedPassword
{
    private string $hash;

    public function __construct(string $hashedPassword)
    {
        $this->hash = $hashedPassword;
    }
    public function getHash(): string
    {
        return $this->hash;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->hash);
    }
}