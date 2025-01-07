<?php

namespace App\ProductCatalog\Part\Domain\Entity;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Service\Domain\Entity\Service;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Money\Money;
use Ramsey\Uuid\Uuid;

class Part
{
    private string $id;
    private string $name;
    private string $partNumber;
    private string $originalPartNumber;
    private Money $unitPrice;
    private float $quantity;
    private Money $totalPrice;
    private ?Car $car = null;
    private ?string $carId = null;
    private ?string $description = null;
    private Category $category;
    private int $categoryId;
    private DateTimeImmutable $createdAt;
    private User $user;
    private string $userId;
    private ?Service $service = null;
    private ?string $serviceId = null;
    private string $status = 'stock';

    public function __construct(
        Category $category,
        string $brand,
        string $partNumber,
        string $originalPartNumber,
        string $name,
        Money $unitPrice,
        float $quantity,
        ?User $user = null,
        ?string $description = null
    )
    {
        $this->category = $category;
        $this->categoryId = $category->getId();

        $this->user = $user;
        $this->userId = $user?->getId();

        $this->partNumber = $partNumber;
        $this->originalPartNumber = $originalPartNumber;
        $this->name = $name;
        $this->description = $description;

        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->totalPrice = $unitPrice->multiply($quantity);
    }

    public function setService(Service $service): void {
        $this->service = $service;
        $this->serviceId = $service->getId();
    }

    public function setCar(Car $car): void
    {
        $this->car = $car;
        $this->carId = $car->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPartNumber(): string
    {
        return $this->partNumber;
    }

    public function getOriginalPartNumber(): string
    {
        return $this->originalPartNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function prePersist(): void
    {
        $this->createdAt = CarbonImmutable::now();
        if (empty($this->id)){
            $this->id = Uuid::uuid7()->toString();
        }
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getUserId(): ?string
    {
        return $this->user?->getId();
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function getCarId(): ?string
    {
        return $this->carId;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}