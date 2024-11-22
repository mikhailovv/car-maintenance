<?php

namespace App\Authorization\User\Infrastructure\Repository;

use App\Authorization\User\Domain\Entity\Token;
use App\Authorization\User\Domain\Repository\TokenRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TokenRepository implements TokenRepositoryInterface
{
    private SessionInterface $session;
    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    private function initSession(): void
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    public function save(Token $token): void
    {
        $this->initSession();

        $this->session->set('auth_token', $token->getValue());
    }

    public function get(): Token
    {
        $this->initSession();

        $tokenValue = $this->session->get('auth_token');

       return new Token($tokenValue);
    }
}