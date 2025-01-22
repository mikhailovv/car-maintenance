<?php

namespace App\ProductCatalog\Part\Application\Service;

use App\ProductCatalog\Part\Application\DTO\PartCategory;
use App\ProductCatalog\Part\Application\Model\GetCategoriesQuery;
use App\ProductCatalog\Part\Domain\Entity\Category;
use App\ProductCatalog\Part\Domain\Entity\Part;
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

        $categoriesAsTree = $this->convertToTree($categories);

        return $this->serializer->serialize($categoriesAsTree, 'json');
    }

    /**
     * @param Category[] $categories
     * @return array
     */
    private function convertToTree(array $categories): array
    {
        $categoriesAsTree = [];
        foreach ($categories as $category){
            $partCategory = new PartCategory($category->getId(), $category->getName());
            if ($category->getParentCategoryId() === null){
                $categoriesAsTree[$partCategory->getId()] = $partCategory;
            } else {
                if ($categoriesAsTree[$category->getParentCategoryId()] instanceof  PartCategory){
                    $categoriesAsTree[$category->getParentCategoryId()]->addSubcategory($partCategory);
                } else {
                    $parentCategory = $category->getParentCategory();
                    $parentPartCategory = new PartCategory($parentCategory->getId(), $parentCategory->getName());
                    $categoriesAsTree[$parentPartCategory->getId()] = $parentPartCategory;
                    $categoriesAsTree[$parentPartCategory->getId()]->addSubcategory($partCategory);
                }
            }
        }

        return array_values($categoriesAsTree);
    }
}