<?php

namespace App\Authorization\User\Application\Controller;

use App\Authorization\User\Application\Model\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/signup', name: 'api_sign_up', methods: ['POST'])]
class SignUpController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);

        $user = $this->handle(new CreateUserCommand($userData));

        return new JsonResponse(['message' => 'Logged in successfully.'], 200);
    }
}