<?php

namespace App\Authorization\User\Infrastructure\Security;

use Carbon\Carbon;
use InvalidArgumentException;

class JwtTokenData
{
    public function __construct(
        private string $userIdentifier,
        private Carbon $issuedAt,
        private Carbon $expiredAt,
    )
    {}

    public static function createFromArray(array $data): self
    {
        if (empty($data['userId'])|| empty($data['iat'])|| empty($data['exp'])) {
            throw new InvalidArgumentException('JWT Token data is empty');
        }

        return new self(
            $data['userId'],
            new Carbon($data['iat']),
            new Carbon($data['exp'])
        );
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getExpiredAt(): Carbon
    {
        return $this->expiredAt;
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userIdentifier,
            'iat' => $this->issuedAt->toDateTime()->getTimestamp(),
            'exp' => $this->expiredAt->toDateTime()->getTimestamp(),
        ];
    }
}