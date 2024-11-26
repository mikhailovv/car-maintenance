<?php

namespace App\ProductCatalog\Car\Application\Service;

use App\ProductCatalog\Car\Application\Model\GetModelsQuery;
use App\ProductCatalog\Car\Domain\Repository\ModelRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class GetModelsHandler
{
    public function __construct(
        private ModelRepositoryInterface $modelRepository,
        private SerializerInterface $serializer
    ){}

    public function __invoke(GetModelsQuery $query): string
    {
        $models = $this->modelRepository->findByBrandSlug($query->getBrandSlug());

        return $this->serializer->serialize(
            $models,
            'json',
            ['groups' => ['brand_read']]
        );
    }
}