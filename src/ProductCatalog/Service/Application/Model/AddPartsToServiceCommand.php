<?php

namespace App\ProductCatalog\Service\Application\Model;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Domain\Entity\Part;

class AddPartsToServiceCommand
{
    /** @var ServicePart[] */
    private array $parts;
    private User $user;
    private string $serviceId;
    private array $partIds;

    public function __construct(string $serviceId, array $parts, User $user)
    {
        $this->user = $user;
        foreach ($parts as $part){
            $this->parts[] = new ServicePart($part['part_id'], $part['quantity']);
            $this->partIds[] = $part['part_id'];
        }
        $this->serviceId = $serviceId;
    }
    /** @return ServicePart[] */
    public function getParts(): array
    {
        return $this->parts;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getPartIds(): array
    {
        return $this->partIds;
    }
}