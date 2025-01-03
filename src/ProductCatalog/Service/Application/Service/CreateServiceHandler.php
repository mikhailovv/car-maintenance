<?php

namespace App\ProductCatalog\Service\Application\Service;

use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use App\ProductCatalog\Service\Application\Model\CreateServiceCommand;
use App\ProductCatalog\Service\Domain\Entity\Service;
use App\ProductCatalog\Service\Domain\Repository\ServiceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class CreateServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private PartRepositoryInterface    $partRepository,
        private SerializerInterface        $serializer
    )
    {
    }

    public function __invoke(CreateServiceCommand $command): string
    {
        $service = new Service(
            $command->getUser(),
            name: $command->getName(),
            unitPrice: $command->getUnitPrice(),
            quantity: $command->getQuantity(),
            shop: $command->getShop()
        );

        if ($command->getPartIds()) {
            $parts = $this->partRepository->findByIds($command->getUser(), $command->getPartIds());
            foreach ($parts as $part) {
                $service->addPart($part);
            }
        }

        $this->serviceRepository->save($service);

        return $this->serializer->serialize(
            $service,
            'json',
            ['groups' => ['service_read']]
        );
    }
}