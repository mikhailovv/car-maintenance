<?php

namespace App\ProductCatalog\Purchase\Application\Service;

use App\ProductCatalog\Purchase\Application\Model\GetInventoryQuery;
use App\ProductCatalog\Purchase\Domain\Repository\InventoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[asMessageHandler]
class GetInventoryHandler
{
    public function __construct(private InventoryRepositoryInterface $inventoryRepository)
    {
    }

    public function __invoke(GetInventoryQuery $query): array
    {
        return $this->inventoryRepository->findByUserId($query->getUser()->getId());
    }
}