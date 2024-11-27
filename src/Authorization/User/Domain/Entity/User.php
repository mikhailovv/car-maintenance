<?php

namespace App\Authorization\User\Domain\Entity;

use App\ProductCatalog\Car\Domain\Entity\Car;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $id;
    private string $email;
    private string $password;
    private DateTimeImmutable $registeredAt;
    private DateTimeImmutable $updatedAt;

    private Collection $cars;

    public function __construct(string $id, string $email, ?string $password=null)
    {
        $this->id = $id;
        $this->email = $email;
        if ($password !== null) {
            $this->password = $password;
        }
        $this->cars = new ArrayCollection();
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

    public function getCars(){
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setUser($this); // Ensure the owning side is updated
        }

        return $this;
    }

}