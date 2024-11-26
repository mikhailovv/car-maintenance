<?php

namespace App\ProductCatalog\Car\Application\Service;

use App\ProductCatalog\Car\Application\Model\GetBrandsQuery;
use App\ProductCatalog\Car\Domain\Repository\BrandRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class GetBrandsHandler
{
    public function __construct(
        private BrandRepositoryInterface $brandRepository,
        private SerializerInterface $serializer
    ){}
    public function __invoke(GetBrandsQuery $query): string
    {
        $brands = $this->brandRepository->findAll();

        return $this->serializer->serialize(
            $brands,
            'json',
            ['groups' => ['brand_read']]
        );
    }
}