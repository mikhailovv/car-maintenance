<?php

namespace App\ProductCatalog\Car\Application\Model;

final class GetCarsQuery
{
    public function __construct(private string $userId)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}