<?php

namespace App\ProductCatalog\Part\Domain\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Domain\Entity\Part;
use Doctrine\DBAL\LockMode;

interface PartRepositoryInterface
{
    public function findAll(): array;

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;

    public function save(Part $part): void;

    public function findByIds(User $user, array $ids): array;
    public function findPartsForUser(User $user, ?int $categoryId = null): array;
}