<?php

namespace App\Authorization\User\Domain\Entity;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $id;
    private string $email;
    private string $password;
    private DateTimeImmutable $registeredAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $id, string $email, ?string $password=null)
    {
        $this->id = $id;
        $this->email = $email;
        if ($password !== null) {
            $this->password = $password;
        }
    }

    public function prePersist(): void
    {
        $this->registeredAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        $this->password = '';
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}