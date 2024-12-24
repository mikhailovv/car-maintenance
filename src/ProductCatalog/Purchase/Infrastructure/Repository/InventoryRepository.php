<?php

namespace App\ProductCatalog\Purchase\Infrastructure\Repository;

use App\ProductCatalog\Purchase\Domain\Entity\Inventory;
use App\ProductCatalog\Purchase\Domain\Repository\InventoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;

class InventoryRepository extends ServiceEntityRepository implements InventoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    public function find(mixed $id, int|LockMode|null $lockMode = null, ?int $lockVersion = null): Inventory|null
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function save(Inventory $inventory): void
    {
        $this->getEntityManager()->persist($inventory);
        $this->getEntityManager()->flush();
    }

    public function findByPartIdAndUserId(string $partId, string $userId): Inventory|null
    {
        return $this->findOneBy(['partId' => $partId, 'userId' => $userId])->getOneOrNullResult();
    }

    public function findByUserId(string $userId): array
    {
       return $this->find(['userId' => $userId]);
    }
}