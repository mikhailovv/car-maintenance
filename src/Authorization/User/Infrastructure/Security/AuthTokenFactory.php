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

        $token = JWT::encode(
            payload: $jwtTokenData->toArray(),
            key: $this->secret,
            alg:'HS256'
        );

        return new AuthToken($token, $user->getUserIdentifier(), $expiredAt);
    }

    public function createByToken(Token $token): AuthToken
    {
        $header = null;
        $tokenData = (array)JWT::decode(
            jwt: $token->getValue(),
            keyOrKeyArray: new Key($this->secret, 'HS256'),
            headers: $headers
        );

        $jwtTokenData = JwtTokenData::createFromArray($tokenData);

        return new AuthToken(
            $token->getValue(),
            $jwtTokenData->getUserIdentifier(),
            $jwtTokenData->getExpiredAt()
        );
    }
}