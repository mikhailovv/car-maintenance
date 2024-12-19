<?php

namespace App\ProductCatalog\Purchase\Domain\Entity;

enum PurchaseType: string
{
    case SERVICE = 'service';
    case PART = 'part';
    case OIL = 'oil';

    public static function values(): array {
        return array_map(fn(PurchaseType $pt) => $pt->value, PurchaseType::cases());
    }
}
