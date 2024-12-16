<?php

namespace App\ProductCatalog\Part\Infrastructure\DataFixtures;

use App\ProductCatalog\Part\Domain\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private array $categories = [
        'Brake system' => ['Brake disc', 'Brake pad', 'Brake components'],
        'Manual transmission' => ['Gear control', 'Repair / maintenance']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->categories as $name => $subCategoryNames) {
            $category = new Category($name);
            $manager->persist($category);

            foreach ($subCategoryNames as $categoryName) {
                $subCategory = new Category($categoryName, $category);
                $manager->persist($subCategory);
            }
        }

        $manager->flush();
    }
}
