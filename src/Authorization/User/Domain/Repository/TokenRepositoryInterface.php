<?php

namespace App\Authorization\User\Domain\Repository;

use App\Authorization\User\Domain\Entity\AuthToken;
use App\Authorization\User\Domain\Entity\Token;

interface TokenRepositoryInterface
{
    public function save(Token $authToken): void;

    public function get(): Token;
}