<?php

namespace App\ProductCatalog\Service\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class GetServiceQuery
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}