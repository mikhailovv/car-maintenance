<?php

namespace App\ProductCatalog\Car\Application\Controller;

use App\ProductCatalog\Car\Application\Model\GetBrandsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/cars/brands', name: 'api_cars_brands_get')]
class GetBrandsController extends AbstractController
{
    use HandleTrait;
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $brands = $this->handle(new GetBrandsQuery());
        return JsonResponse::fromJsonString($brands);
    }
}