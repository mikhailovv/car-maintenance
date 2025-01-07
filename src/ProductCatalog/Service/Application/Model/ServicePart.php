<?php

namespace App\ProductCatalog\Service\Application\Model;

class ServicePart
{
    public function __construct(private string $partId, private int $quantity)
    {
    }

    public function getPartId(): string
    {
        return $this->partId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }


}