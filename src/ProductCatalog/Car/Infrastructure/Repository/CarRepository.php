<?php

namespace App\ProductCatalog\Car\Infrastructure\Repository;

use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarRepository extends ServiceEntityRepository implements
    CarRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $car): void
    {
        $this->getEntityManager()->persist($car);
        $this->getEntityManager()->flush();
    }
}