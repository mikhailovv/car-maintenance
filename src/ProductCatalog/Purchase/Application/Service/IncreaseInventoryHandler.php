<?php

namespace App\ProductCatalog\Purchase\Application\Service;

use App\ProductCatalog\Purchase\Application\Model\IncreaseInventoryCommand;
use App\ProductCatalog\Purchase\Domain\Entity\Inventory;
use App\ProductCatalog\Purchase\Domain\Repository\InventoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[asMessageHandler]
class IncreaseInventoryHandler
{
    public function __construct(
        private InventoryRepositoryInterface $inventoryRepository
    )
    {}

    public function __invoke(IncreaseInventoryCommand $command): void
    {
        $inventory = $this->inventoryRepository->findByPartIdAndUserId(
            $command->getPartId(), $command->getUser()->getId()
        );

        if (null === $inventory) {
            $inventory = new Inventory(
                $command->getUser(),
                $command->getPartId(),
                $command->getQuantity()
            );
        } else {
            $inventory->increaseQuantity($command->getQuantity());
        }

        $this->inventoryRepository->save($inventory);
    }
}