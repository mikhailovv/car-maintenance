<?php

namespace App\ProductCatalog\Service\Infrastructure\Repository;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Service\Domain\Entity\Service;
use App\ProductCatalog\Service\Domain\Repository\ServiceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ServiceRepository extends ServiceEntityRepository implements ServiceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function save(Service $service): void
    {
        $this->getEntityManager()->persist($service);
        foreach ($service->getParts() as $part){
            $this->getEntityManager()->persist($part);
        }
        $this->getEntityManager()->flush();
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->where('s.userId = :user')
            ->setParameter('user', $user->getId())
            ->getQuery()
            ->getResult();
    }
}