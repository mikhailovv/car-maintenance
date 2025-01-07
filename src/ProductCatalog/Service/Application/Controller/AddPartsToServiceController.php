<?php

namespace App\ProductCatalog\Service\Application\Controller;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Service\Application\Model\AddPartsToServiceCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: '/api/services/{serviceId}/parts', name: 'api_add_parts_to_service_post', methods: ['POST'])]
class AddPartsToServiceController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(string $serviceId, #[CurrentUser] User $user, Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);

        $addedParts = $this->handle(new AddPartsToServiceCommand($serviceId, $requestContent, $user));

        return JsonResponse::fromJsonString($addedParts);
    }

}