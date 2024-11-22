<?php

namespace App\Authorization\User\Domain\Repository;

use App\Authorization\User\Domain\Entity\User;
use Doctrine\DBAL\LockMode;

interface UserRepositoryInterface
{
    public function findAll(): array;

    public function find(mixed $id, LockMode|int|null $lockMode = null, int|null $lockVersion = null): object|null;

    public function save(User $user): void;

    public function findByEmail(string $email): ?User;
}