<?php

namespace App\ProductCatalog\Service\Domain\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Service\Domain\Entity\Service;
use Doctrine\DBAL\LockMode;

interface ServiceRepositoryInterface
{
    public function findAll(): array;

    /** @return Service|null */
    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;

    public function save(Service $service): void;

    public function findByUser(User $user): array;
}