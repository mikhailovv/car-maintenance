<?php

namespace App\Authorization\User\Application\Service;

use App\Authorization\User\Application\Model\CreateUserCommand;
use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Domain\Repository\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher

    )
    {
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = $this->userRepository->findByEmail($command->getEmail());
        if ($user){
            return;
        }

        $user = new User(Uuid::uuid7(), $command->getEmail(), $command->getName());
        $passwordHash = $this->passwordHasher->hashPassword($user, $command->getPassword());
        $user->setPasswordHash($passwordHash);

        $this->userRepository->save($user);
    }
}