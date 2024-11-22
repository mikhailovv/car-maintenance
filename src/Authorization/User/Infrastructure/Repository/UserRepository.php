<?php

namespace App\Authorization\User\Infrastructure\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository
    implements UserRepositoryInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->getEntityManager()
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        return $this->findByEmail($identifier);
    }
}