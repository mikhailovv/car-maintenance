<?php

namespace App\ProductCatalog\Service\Application\Model;

use App\Authorization\User\Domain\Entity\User;

class GetServiceQuery
{
    private ?string $carId = null;
    private string $orderBy = 'created_at';
    private string $order = 'ASC';

    public function __construct(private User $user, array $options)
    {
        if (!empty($options['order_by'])){
            if (in_array($options['order_by'], ['created_at', 'mileage', 'total_price'])){
                $this->orderBy = $options['order_by'];
            }
        }

        if (!empty($options['order']) && in_array($options['order'], ['ASC', 'DESC'])){
            $this->order = $options['order'];
        }

        if (!empty($options['car_id'])){
            $this->carId = $options['car_id'];
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCarId(): ?string
    {
        return $this->carId;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

}