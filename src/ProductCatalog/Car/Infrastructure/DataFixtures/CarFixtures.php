<?php

namespace App\ProductCatalog\Car\Infrastructure\DataFixtures;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Domain\Entity\Car;
use Carbon\CarbonImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CarFixtures  extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $bmwOwner = $this->getReference('bmw_owner');

        $compact = new Car('My 325ti compact', 'BMW', '3-series', $bmwOwner);
        $compact->setVin('12345767812');
        $compact->setColor('red');
        $compact->setProducedAt(new CarbonImmutable('2001-10-30'));
        $compact->setRegistrationNumber('219 GJE');

        $manager->persist($compact);


        $touring = new Car('My 318 Touring', 'BMW', '3-series', $bmwOwner);
        $touring->setVin('67812123457');
        $touring->setColor('red');
        $touring->setProducedAt(new CarbonImmutable('2022-05-10'));
        $touring->setRegistrationNumber('322 MJA');

        $manager->persist($touring);


        $mbOwner = new User(
            Uuid::uuid7()->toString(),
            'mercedes-owner@admin.com',
            'mercedes-owner',
            $this->passwordHasher->hashPassword(
                new User('1', 'test@test.com', 'mercedes-owner'),
            'mercedes-owner'
            )
        );
        $manager->persist($mbOwner);

        $vito = new Car('Vito', 'Mercedes-Benz', 'Vito', $mbOwner);
        $vito->setVin('3456789');
        $vito->setColor('black');
        $vito->setRegistrationNumber('345 VIP');
        $vito->setProducedAt(new CarbonImmutable('2020-01-01'));

        $manager->persist($vito);

        $manager->flush();
    }
}