<?php

namespace App\ProductCatalog\Category\Domain\Repository;

use App\ProductCatalog\Category\Domain\Entity\Category;
use Doctrine\DBAL\LockMode;

interface CategoryRepositoryInterface
{
    public function findAll(): array;

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;

    public function save(Category $category): void;
}