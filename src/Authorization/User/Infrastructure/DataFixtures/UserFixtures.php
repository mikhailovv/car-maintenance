<?php

namespace App\Authorization\User\Infrastructure\DataFixtures;

use App\Authorization\User\Domain\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $id = Uuid::uuid7()->toString();
        $email = 'admin@admin.com';
        $user = new User($id, $email);
        $password = $this->passwordHasher->hashPassword($user, 'admin');

        $user = new User($id, $email, $password);
        $manager->persist($user);

        $manager->flush();
    }
}
