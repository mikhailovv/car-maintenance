<?php

namespace App\ProductCatalog\Part\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class GetPartsQuery
{
    public function __construct(private User $user, private ?int $categoryId = null){
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}