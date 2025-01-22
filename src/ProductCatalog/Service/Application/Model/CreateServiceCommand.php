<?php

namespace App\ProductCatalog\Service\Application\Model;

use App\Authorization\User\Domain\Entity\User;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;

class CreateServiceCommand
{
    private string $name;
    private ?string $description = null;
    private string $carId;
    private User $user;
    private array $partIds = [];
    private ?string $shop = null;
    private Money $unitPrice;
    private float $quantity;

    private int $mileage;

    public function __construct(array $serviceData, User $user)
    {
        $this->name = $serviceData['name'] ?? null;
        $this->description = $serviceData['description'] ?? null;
        $this->carId = $serviceData['car_id'] ?? null;
        $this->mileage = $serviceData['mileage'] ?? 0;
        $this->user = $user;


        $unitPrice = $serviceData['unit_price'] ?? null;
        $currency = $serviceData['currency'] ?? null;

        if ($unitPrice === null || $currency === null) {
            throw new InvalidArgumentException('The unit price and the currency must be set');
        }

        $quantity = $serviceData['quantity'] ?? null;
        if ($quantity === null) {
            throw new InvalidArgumentException('The quantity must be set');
        }

        $this->unitPrice = new Money($unitPrice, new Currency($currency));
        $this->quantity = $quantity;

        $this->shop = $serviceData['shop'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCarId(): string
    {
        return $this->carId;
    }

    public function getUser(): User
    {
        return $this->user;
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

    public function getPartIds(): array
    {
        return $this->partIds;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }
}