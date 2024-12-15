<?php

namespace App\ProductCatalog\Car\Application\Service;

use App\ProductCatalog\Car\Application\Model\GetCarsQuery;
use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class GetCarsHandler
{
    public function __construct(
        private CarRepositoryInterface $carRepository,
        private SerializerInterface $serializer
    ){}
    public function __invoke(GetCarsQuery $query): string
    {
        $cars = $this->carRepository->findBy(['userId' => $query->getUserId()]);

        return $this->serializer->serialize(
            $cars,
            'json',
            ['groups' => ['car_read']]
        );
    }
}