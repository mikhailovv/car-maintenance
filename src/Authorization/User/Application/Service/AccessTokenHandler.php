<?php

namespace App\Authorization\User\Application\Service;

use App\Authorization\User\Domain\Entity\AuthToken;
use App\Authorization\User\Domain\Entity\Token;
use App\Authorization\User\Domain\Repository\TokenRepositoryInterface;
use App\Authorization\User\Infrastructure\Security\AuthTokenFactory;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private TokenRepositoryInterface $authTokenRepository,
        private AuthTokenFactory $authTokenFactory
    )
    {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $token = $this->authTokenRepository->get();

        if (!$token->isEqual(new Token($accessToken))) {
            throw new BadCredentialsException('Invalid credentials.');
        }

        $authToken = $this->authTokenFactory->createByToken($token);

        if ($authToken->isExpired()){
            throw new BadCredentialsException('Credentials expired');
        }

        // and return a UserBadge object containing the user identifier from the found token
        // (this is the same identifier used in Security configuration; it can be an email,
        // a UUID, a username, a database ID, etc.)
        return new UserBadge($authToken->getUserIdentifier());
    }

}