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
        $fixtureUsersData = [
            'admin_user' => [
                'email' => 'admin@admin.com',
                'password' => 'admin',
                'name' => 'Admin',
            ],
            'bmw_owner' => [
                'email' => 'bmw-owner@admin.com',
                'password' => 'bmw-owner',
                'name' => 'BMW Owner',
            ],
        ];

        foreach ($fixtureUsersData as $userReferenceKey => $userData){
            $id = Uuid::uuid7()->toString();
            $user = new User($id, $userData['email'], $userData['name']);
            $password = $this->passwordHasher->hashPassword($user, $userData['password']);

            $user = new User($id, $userData['email'], $userData['name'], $password);
            $user->activate();
            $manager->persist($user);

            $this->setReference($userReferenceKey, $user);
        }

        $manager->flush();
    }
}
