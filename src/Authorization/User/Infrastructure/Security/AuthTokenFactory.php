<?php

namespace App\Authorization\User\Infrastructure\Security;

use App\Authorization\User\Domain\Entity\AuthToken;
use App\Authorization\User\Domain\Entity\Token;
use App\Authorization\User\Domain\Entity\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthTokenFactory
{
    public function __construct(private string $secret = 'vm_dev_ILL0ieHR9MjvZj1')
    {
    }

    public function createByUser(User $user): AuthToken
    {
        $userIdentifier = $user->getUserIdentifier();
        $issuedAt = Carbon::now();
        $expiredAt = (Carbon::now())->addDay();

        $jwtTokenData = new JwtTokenData(
            $userIdentifier,
            $issuedAt,
            $expiredAt
        );

        $token = JWT::encode($jwtTokenData->toArray(), $this->secret, 'HS256');

        return new AuthToken($token, $user->getUserIdentifier(), $expiredAt);
    }

    public function createByToken(Token $token): AuthToken
    {
        $tokenData = (array)JWT::decode($token->getValue(), new Key($this->secret, 'HS256'));

        $jwtTokenData = JwtTokenData::createFromArray($tokenData);

        return new AuthToken(
            $token->getValue(),
            $jwtTokenData->getUserIdentifier(),
            $jwtTokenData->getExpiredAt()
        );
    }
}