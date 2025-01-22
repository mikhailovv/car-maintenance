<?php

namespace App\ProductCatalog\Part\Application\DTO;

class PartCategory
{
    private array $subcategories = [];

    public function __construct(private int $id, private string $name)
    {
    }

    public function addSubcategory(PartCategory $subcategory): void
    {
        $this->subcategories[] = $subcategory;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSubcategories(): array
    {
        return $this->subcategories;
    }
}