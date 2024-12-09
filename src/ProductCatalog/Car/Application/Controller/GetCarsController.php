<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Domain\Repository\UserRepositoryInterface;
use App\ProductCatalog\Car\Application\Model\GetCarsQuery;
use App\ProductCatalog\Car\Domain\Entity\Car;
use App\ProductCatalog\Car\Domain\Repository\CarRepositoryInterface;
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
    public function __construct(private MessageBusInterface $messageBus, private UserRepositoryInterface $userRepository, private CarRepositoryInterface $carRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        $cars = [];// $this->handle(new GetCarsQuery($user->getId()));
        $cars = $this->carRepository->findAll();
        return JsonResponse::fromJsonString($cars);
    }
}