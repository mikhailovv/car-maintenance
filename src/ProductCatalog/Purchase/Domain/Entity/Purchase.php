<?php

namespace App\ProductCatalog\Purchase\Domain\Entity;

use App\Authorization\User\Domain\Entity\User;
use DateTimeImmutable;
use InvalidArgumentException;
use Money\Money;
use Ramsey\Uuid\Uuid;

class Purchase
{
    private string $id;
    private PurchaseType $purchaseType;
    private string $itemId;
    private float $quantity;
    private Money $unitPrice;
    private Money $totalPrice;
    private User $user;
    private string $userId;
    private DateTimeImmutable $createdAt;

    /**
     * @param PurchaseType $purchaseType
     * @param string $itemId
     * @param int $quantity
     * @param Money $unitPrice
     */
    public function __construct(PurchaseType $purchaseType, string $itemId, float $quantity, Money $unitPrice, User $user)
    {
        if ($quantity < 0){
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }

        $this->purchaseType = $purchaseType;
        $this->itemId = $itemId;

        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->totalPrice = $unitPrice->multiply($quantity);
        $this->user = $user;
        $this->userId = $user->getId();
    }

    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->id = Uuid::uuid7()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPurchaseType(): PurchaseType
    {
        return $this->purchaseType;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

}