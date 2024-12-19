<?php

namespace App\ProductCatalog\Purchase\Infrastructure\Doctrine\Type;

use App\ProductCatalog\Purchase\Domain\Entity\PurchaseType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PurchaseTypeEnumType extends Type
{
    const PURCHASE_TYPE_ENUM = 'purchase_type_enum';
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'purchase_type_enum';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): PurchaseType
    {
        return PurchaseType::from($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    public function getName(): string
    {
        return self::PURCHASE_TYPE_ENUM;
    }
}