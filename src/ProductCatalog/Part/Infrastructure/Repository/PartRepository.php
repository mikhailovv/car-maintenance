<?php

namespace App\ProductCatalog\Part\Infrastructure\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Domain\Entity\Part;
use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PartRepository extends ServiceEntityRepository implements PartRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Part::class);
    }

    public function save(Part $part): void
    {
        $this->getEntityManager()->persist($part);
        $this->getEntityManager()->flush();
    }

    public function findByIds(User $user, array $ids): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->where('user_id = :user_id')
            ->setParameter('user_id', $user->getId())
            ->getQuery()
            ->getResult();
    }
}