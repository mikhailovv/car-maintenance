<?php

namespace App\ProductCatalog\Part\Application\Service;

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
            $command->getBrand(),
            $command->getPartNumber(),
            $command->getOriginalPartNumber(),
            $name,
            $command->getUser(),
            $description,
        );

        $this->partRepository->save($part);

        return $this->serializer->serialize(
            $part,
            'json',
            ['groups' => ['part_read']]
        );
    }
}