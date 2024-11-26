<?php

namespace App\Authorization\User\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/login', name: 'api_login', methods: ['POST'])]
final class AuthController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }


    public function __invoke(): JsonResponse
    {
        // Authentication is handled by JsonLoginAuthenticator.
        // If successful, Symfony will respond automatically.
        return new JsonResponse(['message' => 'Logged in successfully.'], 200);
    }
//    public function __invoke(Request $request): JsonResponse
//    {
//        $parameters = json_decode(
//            $request->getContent(),
//            true,
//            512,
//            JSON_THROW_ON_ERROR
//        );
//
//        return $this->json([
//            'message' => 'Welcome to your new slava!',
//            'path' => 'src/Controller/ApiLoginController.php',
//            $parameters
//        ]);
////        return $this->handle(
////            new AuthorizeUserCommand($parameters['email'], $parameters['password'])
////        );
//    }
}