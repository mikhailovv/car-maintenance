<?php

namespace App\ProductCatalog\Category\Application\Controller;

use App\ProductCatalog\Category\Application\Model\GetCategoriesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories/', name: 'api_categories_get', methods: ['GET'])]
final class GetCategoriesController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): JsonResponse
    {
        $categories = $this->handle(new GetCategoriesQuery());

        return JsonResponse::fromJsonString($categories);
    }
}