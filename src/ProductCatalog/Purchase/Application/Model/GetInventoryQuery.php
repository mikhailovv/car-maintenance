<?php

namespace App\ProductCatalog\Purchase\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class GetInventoryQuery
{
    public function __construct(private User $user){}

    public function getUser(): User
    {
        return $this->user;
    }
}