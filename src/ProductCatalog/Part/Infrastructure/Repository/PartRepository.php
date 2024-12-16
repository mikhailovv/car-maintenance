<?php

namespace App\ProductCatalog\Part\Infrastructure\Repository;

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

    public function findPartsForUser(string $userId, ?int $categoryId = null): array
    {
        $query =  $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->orWhere('p.user is null')
            ->setParameter('user', $userId);

        if (null !== $categoryId) {
            $query->andWhere('p.category = :category')
                ->setParameter('category', $categoryId);
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}