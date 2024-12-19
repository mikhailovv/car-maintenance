<?php

namespace App\ProductCatalog\Purchase\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class IncreaseInventoryCommand
{
    public function __construct(private User $user, private string $partId, private float $quantity)
    {
    }

    public function getPartId(): string
    {
        return $this->partId;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}