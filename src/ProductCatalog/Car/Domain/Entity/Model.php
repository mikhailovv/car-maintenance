<?php

namespace App\ProductCatalog\Car\Domain\Entity;

class Model
{
    private int $id;
    private string $name;
    private string $brandSlug;
    private int $weight;

    public function __construct(string $name, string $brandSlug, int $weight = 0)
    {
        $this->name = $name;
        $this->brandSlug = $brandSlug;
        $this->weight = $weight;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrandSlug(): string
    {
        return $this->brandSlug;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}