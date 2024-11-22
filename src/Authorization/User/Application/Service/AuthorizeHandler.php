<?php

namespace App\Authorization\User\Application\Service;

use App\Authorization\User\Application\Model\AuthorizeUserCommand;
use App\Authorization\User\Domain\Exception\InvalidCredentialException;
use App\Authorization\User\Domain\Repository\UserRepositoryInterface;
use App\Authorization\User\Infrastructure\Security\TokenGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
class AuthorizeHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SerializerInterface $serializer
    ){
    }

    public function __invoke(AuthorizeUserCommand $authorizeUserCommand) :string
    {
        $user = $this->userRepository->load($authorizeUserCommand->getEmail());
        if (!$user || !$user->getPassword()->verifyPassword($authorizeUserCommand->getPassword())) {
            throw new InvalidCredentialException('Invalid email or password');
        }

        return $this->serializer->serialize(['token' => TokenGenerator::generateToken($user)], 'json');
    }
}