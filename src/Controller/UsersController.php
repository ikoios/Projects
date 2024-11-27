<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/newUser', name: 'new_user', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, SerializerInterface $serializer): JsonResponse
    {
        try {
            $datas = $request->toArray();

            $user = new Users;
            $user->setFirstName($datas['first_name'])
                ->setLastName($datas['last_name'])
                ->setPhone($datas['phone'])
                ->setMail($datas['mail'])
                ->setIdentifier($datas['identifier'])
                ->setPassword($datas['password']);

            /**
             * Get the registered password and hash it
             */
            // $password = $datas['password'];

            // $hashedPassword = $passwordHasher->hashPassword($user, $password);

            // $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            $json = $serializer->serialize($user, 'json', ['groups' => 'user_read']);

            return new JsonResponse($json, 201, [], true);
        } catch (Exception $e) {
            return $this->json([
                'error' => 'Une erreur s\'est produite',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
