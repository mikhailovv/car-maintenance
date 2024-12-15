<?php

namespace App\ProductCatalog\Car\Application\Service;

use App\ProductCatalog\Car\Application\Model\CreateCarCommand;
use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class CreateCarHandler
{
    public function __construct(
        private CarRepositoryInterface $carRepository,
        private SerializerInterface $serializer
    ){}
    public function __invoke(CreateCarCommand $command): string
    {
        $car = new Car(
            $command->getName(),
            $command->getBrand(),
            $command->getModel(),
            $command->getUser()
        );
        if ($command->getProducedAt() !== null) {
            $car->setProducedAt($command->getProducedAt());
        }
        $car->setColor($command->getColor());
        $car->setVin($command->getVin());
        $car->setRegistrationNumber($command->getRegistrationNumber());

        $this->carRepository->save($car);

        return $this->serializer->serialize(
            $car,
            'json',
            ['groups' => ['car_read']]
        );
    }
}