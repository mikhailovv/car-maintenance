<?php

namespace App\ProductCatalog\Part\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Category
{
    private int $id;
    private string $name;
    private int $parentCategoryId;
    private ?Category $parentCategory;
    private Collection $subCategories;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $name, ?Category $parentCategory = null){
        $this->name = $name;
        $this->parentCategory = $parentCategory;
        $this->subCategories = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function initUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getParentCategoryId(): string
    {
        return $this->parentCategoryId;
    }
}