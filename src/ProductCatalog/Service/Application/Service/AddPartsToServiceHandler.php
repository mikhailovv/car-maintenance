<?php

namespace App\ProductCatalog\Service\Application\Service;

use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use App\ProductCatalog\Service\Application\Model\AddPartsToServiceCommand;
use App\ProductCatalog\Service\Domain\Repository\ServiceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class AddPartsToServiceHandler
{
    public function __construct(
        private PartRepositoryInterface    $partRepository,
        private ServiceRepositoryInterface $serviceRepository,
        private SerializerInterface        $serializer
    )
    {
    }

    public function __invoke(AddPartsToServiceCommand $addPartsToServiceCommand): string
    {
        $parts = $this->partRepository->findByIds(
            $addPartsToServiceCommand->getUser(),
            $addPartsToServiceCommand->getPartIds()
        );

        $service = $this->serviceRepository->find($addPartsToServiceCommand->getServiceId());
        foreach ($parts as $part) {
            $service->addPart($part);
        }

        $this->serviceRepository->save($service);

        return $this->serializer->serialize(
            $service,
            'json',
            ['groups' => ['service_with_parts_read']]
        );

    }
}