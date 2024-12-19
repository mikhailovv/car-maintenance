<?php

namespace App\ProductCatalog\Purchase\Domain\Entity;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Domain\Entity\Part;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class Inventory
{
    private string $id;
    private string $partId;
    private Part $part;
    private float $quantity;
    private string $userId;
    private User $user;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(User $user, string $partId, float $quantity)
    {
        $this->partId = $partId;
        $this->quantity = $quantity;
        $this->user = $user;
        $this->userId = $this->user->getId();
    }

    public function prePersist(): void
    {
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
        $this->id = Uuid::uuid7()->toString();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = CarbonImmutable::now();
    }

    public function increaseQuantity(float $quantity): void
    {
        $this->quantity += $quantity;
    }

    public function decreaseQuantity(float $quantity): void
    {
        if ($this->quantity - $quantity < 0){
            throw new InvalidArgumentException('The quantity cannot be negative');
        }
        $this->quantity -= $quantity;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPartId(): string
    {
        return $this->partId;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}