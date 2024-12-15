<?php

namespace App\ProductCatalog\Car\Application\Model;

use App\Authorization\User\Domain\Entity\User;
use Carbon\CarbonImmutable;

class CreateCarCommand
{
    private string $name;
    private string $brand;
    private string $model;
    private string $color;
    private string $registrationNumber;
    private string $vin;
    private ?CarbonImmutable $producedAt = null;
    private User $user;

    public function __construct(array $data, User $user)
    {
        if ($data['producedAt']){
            $this->producedAt = CarbonImmutable::create($data['producedAt']);
        }

        $this->name = $data['name'] ?? '';
        $this->brand = $data['brand'] ?? '';
        $this->model = $data['model'] ?? '';
        $this->color = $data['color'] ?? '';
        $this->registrationNumber = $data['registrationNumber'] ?? '';
        $this->vin = $data['vin'] ?? '';
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function getProducedAt(): ?CarbonImmutable
    {
        return $this->producedAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}