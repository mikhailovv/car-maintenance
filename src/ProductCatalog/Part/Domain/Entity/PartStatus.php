<?php

namespace App\ProductCatalog\Part\Domain\Entity;

enum PartStatus
{
    case STOCK;
    case INSTALLED;
}