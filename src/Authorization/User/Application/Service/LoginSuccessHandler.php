<?php

namespace App\Authorization\User\Application\Service;

use App\Authorization\User\Domain\Entity\User;
use App\Authorization\User\Domain\Repository\TokenRepositoryInterface;
use App\Authorization\User\Infrastructure\Security\AuthTokenFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private AuthTokenFactory         $authTokenFactory,
        private TokenRepositoryInterface $authTokenRepository)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        /** @var User $user */
        $user = $token->getUser();

        $authToken = $this->authTokenFactory->createByUser($user);
        $this->authTokenRepository->save($authToken->getToken());

        return new JsonResponse([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getName(),
            ],
            'token' => $authToken->getToken()->getValue(), // Generate and return a token here (e.g., JWT)
        ]);
    }
}