<?php

namespace App\Authorization\User\Domain\Entity;

enum UserStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case SUSPENDED = 'SUSPENDED';
    case DELETED = 'DELETED';
}