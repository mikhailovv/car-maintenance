<?php

namespace App\ProductCatalog\Service\Domain\Entity;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Part\Domain\Entity\Part;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Money\Money;
use Ramsey\Uuid\Uuid;

class Service
{
    private string $id;
    private string $name;
    private Money $unitPrice;
    private float $quantity;
    private ?string $shop = null;
    private Money $totalPrice;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;
    private Collection $parts;
    private User $user;
    private string $userId;
    private int $mileage;
    private Car $car;
    private string $carId;

    public function __construct(User $user, Car $car, string $name, Money $unitPrice, float $quantity, int $mileage, ?string $shop = null)
    {
        $this->user = $user;
        $this->userId = $user->getId();
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->totalPrice = $unitPrice->multiply($quantity);
        $this->shop = $shop;
        $this->parts = new ArrayCollection();
        $this->mileage = $mileage;
        $this->car = $car;
        $this->carId = $car->getId();
    }

    public function addPart(Part $part): void
    {
        if (empty($this->id)){
            $this->prePersist();
        }

        $this->parts->add($part);
        $part->setService($this);
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getShop(): ?string
    {
        return $this->shop;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getCarId(): string
    {
        return $this->carId;
    }
}