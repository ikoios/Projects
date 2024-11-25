<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function getAllUsers(UsersRepository $usersRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $users = $usersRepository->findAll();

            $json = $serializer->serialize($users, 'json', ['groups' => 'user_read']);

            return new JsonResponse($json, 200, [], true);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur s\'est produite',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // #[Route('createTeam', namme: 'create_team', methods: ['POST'])]
    // public function createTeam(UsersRepository $usersRepository): Response {
    //     $user = new Users;
    // }
}
