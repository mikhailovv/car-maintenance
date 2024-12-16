<?php

namespace App\ProductCatalog\Part\Infrastructure\DataFixtures;

use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Infrastructure\DataFixtures\UserFixtures;use App\ProductCatalog\Part\Domain\Entity\Category;
use App\ProductCatalog\Part\Domain\Entity\Part;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class PartFixtures extends Fixture implements DependentFixtureInterface
{
    private array $categories = [
        'Brake system' => ['Brake disc', 'Brake pad', 'Brake components'],
        'Manual transmission' => ['Gear control', 'Repair / maintenance']
    ];

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)->findBy(
            ['name' => ['Brake disc', 'Brake pad']]
        );

        $data = [
            'Brake disc'  => [
                ['150.1288.52 Sport Z', 'Zimmermann'],
                ['09.D113.11', 'BREMBO'],
            ],
            'Brake pad' => [
                ['P06070', 'BREMBO'],
                ['2550601', 'TEXTAR'],
                ['GDB1344DTE', 'TRW']
            ],
        ];

        foreach ($categories as $category) {
            $categoryName = $category->getName();
            foreach ($data[$categoryName] as $partData) {
                $part = new Part(
                    $category,
                    Uuid::uuid7()->toString(),
                    $partData[1],
                    $partData[0],
                    implode('/', $partData),
                );
                $manager->persist($part);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class, UserFixtures::class];
    }

}
