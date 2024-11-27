<?php

namespace App\ProductCatalog\Car\Domain\Entity;

use App\Authorization\User\Domain\Entity\User;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Car
{
    private string $id;
    private string $name;
    private string $brand;
    private string $model;
    private int $year;
    private string $color;
    private string $registrationNumber;
    private string $vin;
    private string $userId;
    private User $user;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $name, string $brand, string $model, int $year, User $user)
    {
        $this->name = $name;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->user = $user;
        $this->userId = $user->getId();
    }

    public function prePersist(): void
    {
        if (empty($this->id)){
            $this->id = Uuid::uuid7()->toString();
        }
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): void
    {
        $this->registrationNumber = $registrationNumber;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

}