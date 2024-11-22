<?php

namespace App\Authorization\User\Application\Model;

class AuthorizeUserCommand
{
    public function __construct(private string $email, private string $password)
    {
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function getPassword(): string {
        return $this->password;
    }
}