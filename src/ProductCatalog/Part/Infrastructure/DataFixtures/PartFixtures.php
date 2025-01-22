<?php

namespace App\ProductCatalog\Part\Infrastructure\DataFixtures;

use App\Authorization\User\Infrastructure\DataFixtures\UserFixtures;
use App\ProductCatalog\Part\Domain\Entity\Part;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

class PartFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $brakeDiscCategory = $this->getReference('brake_disc_category');
        $brakePadCategory = $this->getReference('brake_pad_category');
        $user = $this->getReference('bmw_owner');

        $brakeDiscPart = new Part(
            $brakeDiscCategory,
            'ZIMMERMANN',
            '150.1288.52',
            '34111164539',
            'ZIMMERMANN',
            new Money(152, new Currency('EUR')),
            2,
            $user
        );

        $manager->persist($brakeDiscPart);

        $brakePadPart = new Part(
            $brakePadCategory,
            'EBC',
            'DP41211R',
            '1160356',
            'EBC yellow stuff',
            new Money(128, new Currency('EUR')),
            1,
            $user
        );

        $manager->persist($brakePadPart);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}