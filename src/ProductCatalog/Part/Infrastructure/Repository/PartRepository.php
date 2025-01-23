<?php

namespace App\ProductCatalog\Part\Infrastructure\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Domain\Entity\Car;
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
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findPartsForUser(User $user, ?Car $car=null, ?int $categoryId = null): array
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->setParameter('user', $user);

        if ($categoryId){
            $query->andWhere('p.category_id = :category_id')
                ->setParameter('category_id', $categoryId);
        }

        if ($car){
            $query->andWhere('p.car = :car')
                ->setParameter('car', $car);
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}