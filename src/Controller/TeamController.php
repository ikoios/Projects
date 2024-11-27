<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TeamController extends AbstractController
{
    #[Route('/createTeam/{id}', name: 'create_team', methods: ['POST'])]
    public function createTeam(Request $request, UsersRepository $usersRepository, SerializerInterface $serializer, EntityManagerInterface $manager, $id): JsonResponse
    {
        $datas = $request->toArray();

        $user = $usersRepository->find($id);

        $team = new Team;

        $team->setName($datas['name'])
            ->addUser($user);

        $manager->persist($team);
        $manager->flush();

        $json = $serializer->serialize($team, 'json', ['groups' => 'team_read']);
        return new JsonResponse($json, 201, [], true);
    }
}
