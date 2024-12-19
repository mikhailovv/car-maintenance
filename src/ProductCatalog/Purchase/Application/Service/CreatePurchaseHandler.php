<?php

namespace App\ProductCatalog\Purchase\Application\Service;

use App\ProductCatalog\Part\Domain\Repository\PartRepositoryInterface;
use App\ProductCatalog\Purchase\Application\Model\CreatePurchaseCommand;
use App\ProductCatalog\Purchase\Domain\Entity\Purchase;
use App\ProductCatalog\Purchase\Domain\Entity\PurchaseType;
use App\ProductCatalog\Purchase\Domain\Repository\PurchaseRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[asMessageHandler]
class CreatePurchaseHandler
{
    public function __construct(
        private PurchaseRepositoryInterface $purchaseRepository,
        private PartRepositoryInterface     $partRepository,
        private SerializerInterface         $serializer
    )
    {
    }

    public function __invoke(CreatePurchaseCommand $command): string
    {
        switch ($command->getItemPurchaseType()){
            case PurchaseType::OIL:
                break;
            case PurchaseType::PART:
                $item = $this->partRepository->findByIdAndUser($command->getItemId(), $command->getUser()->getId());
                break;
            case PurchaseType::SERVICE:
                break;
        }

        if (null === $item){
            throw new InvalidArgumentException('Item does not exist');
        }

        $purchase = new Purchase(
            $command->getItemPurchaseType(),
            $item->getId(),
            $command->getQuantity(),
            $command->getUnitPrice(),
            $command->getUser()
        );

        $this->purchaseRepository->save($purchase);

        return $this->serializer->serialize(
            $purchase,
            'json',
            ['groups' => ['purchase_read']]
        );
    }
}