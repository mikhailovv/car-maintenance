<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Domain\Repository\UserRepositoryInterface;
use App\ProductCatalog\Car\Application\Model\GetCarsQuery;
use App\ProductCatalog\Car\Domain\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/cars', name: 'api_cars_get')]
class GetCarsController extends AbstractController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus, private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(#[CurrentUser] User $user): JsonResponse
    {
        $data = $user->getCars()->map(
            fn (Car $car) => ['user_id' => $car->getUser()->getId(), 'car_id' => $car->getId()]);
        return new JsonResponse($data);

        $cars = $this->handle(new GetCarsQuery($user->getId()));

        return JsonResponse::fromJsonString($cars);
    }
}