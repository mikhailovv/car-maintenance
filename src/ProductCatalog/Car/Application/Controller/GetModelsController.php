<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\ProductCatalog\Car\Application\Model\GetBrandsQuery;
use App\ProductCatalog\Car\Application\Model\GetModelsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/cars/{brandSlug}/models', name: 'api_cars_models_get')]
class GetModelsController extends AbstractController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(string $brandSlug): JsonResponse
    {
        $brands = $this->handle(new GetModelsQuery($brandSlug));
        return JsonResponse::fromJsonString($brands);
    }
}