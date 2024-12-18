<?php

namespace App\ProductCatalog\Purchase\Application\Model;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Purchase\Domain\Entity\PurchaseType;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;

class CreatePurchaseCommand
{
    private string $itemId;
    private User $user;
    private float $quantity;
    private Money $unitPrice;
    private PurchaseType $itemPurchaseType;

    public function __construct(array $requestData, User $user)
    {
        $unitPrice = $requestData['unit_price'] ?? null;
        $currency = $requestData['currency'] ?? null;

        if ($unitPrice === null || $currency === null) {
            throw new InvalidArgumentException('The unit price and the currency must be set');
        }

        $quantity = $requestData['quantity'] ?? null;
        if ($quantity === null) {
            throw new InvalidArgumentException('The quantity must be set');
        }

        if ($requestData['item_type'] === null || PurchaseType::tryFrom($requestData['item_type']) === null){
            throw new InvalidArgumentException('The item type must be set');
        }

        if ($requestData['item_id'] === null){
            throw new InvalidArgumentException('The item_id must be set');
        }

        $this->quantity = $quantity;
        $this->itemPurchaseType = PurchaseType::from($requestData['item_type']);
        $this->unitPrice = new Money($unitPrice, new Currency($currency));
        $this->user = $user;
        $this->itemId = $requestData['item_id'];
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function getItemPurchaseType(): PurchaseType
    {
        return $this->itemPurchaseType;
    }


}