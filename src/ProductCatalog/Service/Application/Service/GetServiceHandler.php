<?php

namespace App\ProductCatalog\Service\Application\Service;

use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use App\ProductCatalog\Service\Application\Model\CreateServiceCommand;
use App\ProductCatalog\Service\Application\Model\GetServiceQuery;
use App\ProductCatalog\Service\Domain\Entity\Service;
use App\ProductCatalog\Service\Domain\Repository\ServiceRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class GetServiceHandler
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepository,
        private SerializerInterface        $serializer
    )
    {
    }

    public function __invoke(GetServiceQuery $query): string
    {
        $services = $this->serviceRepository->findByUser($query->getUser());

        return $this->serializer->serialize(
            $services,
            'json',
            ['groups' => ['service_read']]
        );
    }
}