<?php

namespace App\ProductCatalog\Car\Application\Model;

final class GetModelsQuery
{
    public function __construct(private string $brandSlug)
    {
    }

    public function getBrandSlug(): string
    {
        return $this->brandSlug;
    }
}