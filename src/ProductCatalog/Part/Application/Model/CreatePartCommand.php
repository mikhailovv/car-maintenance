<?php

namespace App\ProductCatalog\Part\Application\Model;

use App\Authorization\User\Domain\Entity\User;
use Money\Currency;
use Money\Money;

class CreatePartCommand
{
    private string $partNumber;
    private ?string $originalPartNumber = null;
    private ?string $name = null;
    private ?string $description = null;
    private int $categoryId;
    private Money $unitPrice;
    private float $quantity;
    private User $user;
    private string $carId;

    public function __construct(array $partData, User $user)
    {
        $this->partNumber = $partData['part_number'];
        $this->name = $partData['name'] ?? null;
        $this->description = $partData['description'] ?? null;
        $this->originalPartNumber = $partData['original_part_number'] ?? null;
        $this->categoryId = $partData['category_id'];
        $this->unitPrice = new Money($partData['unit_price']['amount'], new Currency($partData['unit_price']['currency']));
        $this->quantity = $partData['quantity'];
        $this->carId = $partData['car_id'];
        $this->user = $user;
    }

    public function getPartNumber(): string
    {
        return $this->partNumber;
    }

    public function getOriginalPartNumber(): ?string
    {
        return $this->originalPartNumber;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCarId(): string
    {
        return $this->carId;
    }
}