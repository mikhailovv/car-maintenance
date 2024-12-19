<?php

namespace App\ProductCatalog\Purchase\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Purchase\Application\Model\GetInventoryQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/inventories', name: 'api_inventories_post', methods: ['GET'])]
class GetInventoryController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $inventories = $this->handle(new GetInventoryQuery($user));

        return JsonResponse::fromJsonString($inventories);
    }
}