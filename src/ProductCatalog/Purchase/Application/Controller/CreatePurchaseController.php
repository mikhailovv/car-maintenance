<?php

namespace App\ProductCatalog\Purchase\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Purchase\Application\Model\CreatePurchaseCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/purchase', name: 'api_purchase_post', methods: ['POST'])]
class CreatePurchaseController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);

        $part = $this->handle(new CreatePurchaseCommand($requestContent, $user));

        return JsonResponse::fromJsonString($part);
    }
}
