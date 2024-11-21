<?php

namespace App\ProductCatalog\Category\Domain\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Category
{
    private string $id;
    private string $name;

    private string $parentCategoryId;
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
        if (empty($this->id)) {
            $this->id = Uuid::uuid7()->toString();
        }

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