<?php

namespace App\ProductCatalog\Purchase\Domain\Repository;

use App\ProductCatalog\Purchase\Domain\Entity\Purchase;
use Doctrine\DBAL\LockMode;

interface PurchaseRepositoryInterface
{
    public function findAll(): array;

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;

    public function save(Purchase $purchase): void;
}