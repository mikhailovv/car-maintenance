<?php

namespace App\ProductCatalog\Car\Infrastructure\Repository;

use App\ProductCatalog\Car\Domain\Entity\Brand;
use App\ProductCatalog\Car\Domain\Entity\Model;
use App\ProductCatalog\Car\Domain\Repository\BrandRepositoryInterface;
use App\ProductCatalog\Car\Domain\Repository\ModelRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

class ModelRepository extends ServiceEntityRepository implements ModelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function save(Model $model): void
    {
        $this->getEntityManager()->persist($model);
        $this->getEntityManager()->flush();
    }

    public function findByBrandSlug(string $brandSlug): array
    {
        return $this->getEntityManager()
            ->getRepository(Model::class)
            ->findBy(
                ['brandSlug' => $brandSlug],
                ['weight' => 'ASC']
            );
    }
}