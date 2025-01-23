<?php

namespace App\ProductCatalog\Service\Application\Service;

use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use App\ProductCatalog\Service\Application\Model\GetServiceQuery;
use App\ProductCatalog\Service\Domain\Repository\ServiceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class GetServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private CarRepositoryInterface     $carRepository,
        private SerializerInterface        $serializer
    )
    {
    }

    public function __invoke(GetServiceQuery $query): string
    {
        if ($query->getCarId() !== null){
            $car = $this->carRepository->find($query->getCarId());
        }

        $services = $this->serviceRepository->findByUser($query->getUser(), $car ?? null);

        return $this->serializer->serialize(
            $services,
            'json',
            ['groups' => ['service_read']]
        );
    }
}