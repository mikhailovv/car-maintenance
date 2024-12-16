<?php

namespace App\ProductCatalog\Part\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Part\Application\Model\CreatePartCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/parts', name: 'api_part_post', methods: ['POST'])]
class CreatePartController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(#[CurrentUser] User $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);

        $part = $this->handle(new CreatePartCommand($requestContent, $user));

        return JsonResponse::fromJsonString($part);
    }
}