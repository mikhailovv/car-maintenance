<?php

namespace App\ProductCatalog\Purchase\Infrastructure\Repository;

use App\ProductCatalog\Purchase\Domain\Entity\Purchase;
use App\ProductCatalog\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PurchaseRepository extends ServiceEntityRepository implements PurchaseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function save(Purchase $purchase): void
    {
        $this->getEntityManager()->persist($purchase);
        $this->getEntityManager()->flush();
    }
}