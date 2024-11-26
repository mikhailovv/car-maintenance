<?php

namespace App\ProductCatalog\Car\Domain\Repository;

use Doctrine\Common\Collections\Collection;

interface ModelRepositoryInterface
{
    public function findByBrandSlug(string $brandSlug): array;
}