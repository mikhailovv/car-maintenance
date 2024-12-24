<?php

namespace App\ProductCatalog\Purchase\Domain\Entity;

use App\ProductCatalog\Part\Domain\Entity\Part;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Job
{
    private string $id;
    private string $name;
    private string $description;
    private Collection $parts;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->parts = new ArrayCollection();
    }

    public function addPart(Part $part): void
    {
        $this->parts->add($part);
    }

    public function removePart(Part $part): void
    {
        $this->parts = $this->parts->filter(fn(Part $p) => $p->getId() !== $part->getId());
    }

    public function deleteParts(): void
    {
        $this->parts->clear();
    }

    public function prePersist(): void
    {
        $this->id = Uuid::uuid7()->toString();
        $this->createdAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = CarbonImmutable::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getParts(): Collection
    {
        return $this->parts;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}