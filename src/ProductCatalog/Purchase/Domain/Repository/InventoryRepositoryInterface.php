<?php

namespace App\ProductCatalog\Purchase\Domain\Repository;

use App\ProductCatalog\Purchase\Domain\Entity\Inventory;
use Doctrine\DBAL\LockMode;

interface InventoryRepositoryInterface
{
    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;
    public function save(Inventory $inventory): void;
    public function findByPartIdAndUserId(string $partId, string $userId): Inventory|null;
    public function findByUserId(string $userId): array;
}