<?php

namespace App\ProductCatalog\Part\Application\Service;

use App\ProductCatalog\Part\Application\Model\GetCategoriesQuery;
use App\ProductCatalog\Part\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
final class GetCategoriesHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private SerializerInterface $serializer,
    ){}
    public function __invoke(GetCategoriesQuery $query): string
    {
        $categories = $this->categoryRepository->findAll();

        return $this->serializer->serialize($categories, 'json', ['groups' => 'category_read']);
    }
}