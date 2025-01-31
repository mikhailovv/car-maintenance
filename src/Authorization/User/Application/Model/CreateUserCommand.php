<?php

namespace App\Authorization\User\Application\Model;

use http\Exception\InvalidArgumentException;

class CreateUserCommand
{
    private string $name;
    private string $email;
    private string $password;
    public function __construct(array $data)
    {
        if (!$data['name'] || !$data['email'] || !$data['password']){
            throw new InvalidArgumentException('All fields are required');
        }

        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}