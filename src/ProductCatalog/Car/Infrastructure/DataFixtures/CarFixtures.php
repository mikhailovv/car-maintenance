<?php

namespace App\ProductCatalog\Car\Infrastructure\DataFixtures;

use App\Authorization\User\Domain\Entity\User;
use App\ProductCatalog\Car\Domain\Entity\Brand;
use App\ProductCatalog\Car\Domain\Entity\Car;
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

        $bmwOwner = new User(Uuid::uuid7()->toString(), 'bmw-owner@admin.com', $this->passwordHasher->hashPassword(new User('1', 'test@test.com'),  'bmw-owner'));
        $manager->persist($bmwOwner);

        $compact = new Car('My 325ti compact', 'BMW', '3-series', 2001, $bmwOwner);
        $compact->setVin('12345767812');
        $compact->setColor('red');
        $compact->setRegistrationNumber('219 GJE');

        $manager->persist($compact);


        $touring = new Car('My 318 Touring', 'BMW', '3-series', 2022, $bmwOwner);
        $touring->setVin('67812123457');
        $touring->setColor('red');
        $touring->setRegistrationNumber('322 MJA');

        $manager->persist($touring);


        $mbOwner = new User(Uuid::uuid7()->toString(), 'mercedes-owner@admin.com', $this->passwordHasher->hashPassword(new User('1', 'test@test.com'),  'mercedes-owner'));
        $manager->persist($mbOwner);

        $vito = new Car('Vito', 'Mercedes-Benz', 'Vito', 2018, $mbOwner);
        $vito->setVin('3456789');
        $vito->setColor('black');
        $vito->setRegistrationNumber('345 VIP');

        $manager->persist($vito);

        $manager->flush();
    }
}