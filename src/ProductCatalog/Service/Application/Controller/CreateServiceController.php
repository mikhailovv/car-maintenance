<?php

namespace App\ProductCatalog\Service\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Application\Model\CreatePartCommand;
use App\ProductCatalog\Service\Application\Model\CreateServiceCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


#[Route(path: '/api/services', name: 'api_service_post', methods: ['POST'])]
class CreateServiceController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);

        $service = $this->handle(new CreateServiceCommand($requestContent, $user));

        return JsonResponse::fromJsonString($service, JsonResponse::HTTP_CREATED);
    }
}
