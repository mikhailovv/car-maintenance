<?php

namespace App\ProductCatalog\Part\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Application\Model\GetCategoriesQuery;
use App\ProductCatalog\Part\Application\Model\GetPartsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/parts', name: 'api_parts_get', methods: ['GET'])]
final class GetPartsController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $parts = $this->handle(new GetPartsQuery($user, $request->get('category_id')));

        return JsonResponse::fromJsonString($parts);
    }
}