<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Application\Model\CreateCarCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/cars', name: 'api_cars_post', methods: ['POST'])]
class CreateCarController extends AbstractController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);

        $car = $this->handle(new CreateCarCommand($requestContent, $user));

        return JsonResponse::fromJsonString($car);
    }
}