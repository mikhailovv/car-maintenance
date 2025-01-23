<?php

namespace App\ProductCatalog\Part\Application\Service;

use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use App\ProductCatalog\Part\Application\Model\GetPartsQuery;
use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class GetPartsHandler
{
    public function __construct(
        private PartRepositoryInterface $partRepository,
        private CarRepositoryInterface  $carRepository,
        private SerializerInterface     $serializer,
    )
    {
    }

    public function __invoke(GetPartsQuery $query): string
    {
        if ($query->getCarId()){
            $car = $this->carRepository->find($query->getCarId());
        }

        $parts = $this->partRepository->findPartsForUser(
            $query->getUser(),
            $car ?? null,
            $query->getCategoryId()
        );

        return $this->serializer->serialize(
            $parts,
            'json',
            ['groups' => 'part_read']
        );
    }
}