<?php

namespace App\ProductCatalog\Part\Application\Service;

use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
use App\ProductCatalog\Part\Application\Model\CreatePartCommand;
use App\ProductCatalog\Part\Domain\Entity\Part;
use App\ProductCatalog\Part\Domain\Repository\CategoryRepositoryInterface;
use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class CreatePartHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private PartRepositoryInterface     $partRepository,
        private CarRepositoryInterface      $carRepository,
        private SerializerInterface         $serializer
    )
    {
    }

    public function __invoke(CreatePartCommand $command): string
    {
        $category = $this->categoryRepository->findOneBy(['id' => $command->getCategoryId()]);
        if (null === $category) {
            throw new InvalidArgumentException('Category not found');
        }

        $description = $command->getDescription();

        $name = $command->getName();
        if (null === $name) {
            $name = $command->getBrand() . ' / ' . $command->getPartNumber();
        }

        $part = new Part(
            $category,
            $command->getPartNumber(),
            $command->getOriginalPartNumber(),
            $name,
            $command->getUnitPrice(),
            $command->getQuantity(),
            $command->getUser(),
            $description,
        );

        if ($command->getCarId()){
            /** @var Car $car */
            $car = $this->carRepository->find($command->getCarId());
            if (!$car) {
                throw new \InvalidArgumentException('Car not found');
            }

            $part->setCar($car);
        }

        $this->partRepository->save($part);

        return $this->serializer->serialize(
            $part,
            'json',
            ['groups' => ['part_read']]
        );
    }
}