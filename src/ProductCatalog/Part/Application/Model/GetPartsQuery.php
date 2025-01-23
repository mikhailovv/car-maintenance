<?php

namespace App\ProductCatalog\Part\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class GetPartsQuery
{
    public function __construct(
        private User  $user,
        private array $options = []
    )
    {
    }

    public function getCategoryId(): ?int
    {
        return $this->options['category_id'] ?? null;
    }

    public function getCarId(): ?string
    {
        return $this->options['car_id'] ?? null;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}