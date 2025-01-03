<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Application\Model\GetCarsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/cars', name: 'api_cars_get', methods: ['GET'])]
class GetCarsController extends AbstractController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user): JsonResponse
    {
        $cars = $this->handle(new GetCarsQuery($user->getId()));

        return JsonResponse::fromJsonString($cars);
    }
}