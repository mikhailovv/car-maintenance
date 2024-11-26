<?php

namespace App\ProductCatalog\Car\Infrastructure\Repository;

use App\ProductCatalog\Car\Domain\Entity\Brand;
use App\ProductCatalog\Car\Domain\Repository\BrandRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BrandRepository extends ServiceEntityRepository implements BrandRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function save(Brand $brand): void
    {
        $this->getEntityManager()->persist($brand);
        $this->getEntityManager()->flush();
    }
}