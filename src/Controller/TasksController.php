<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Tasks;
use App\Repository\AddressRepository;
use App\Repository\TasksRepository;
use App\Repository\TeamRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks', methods: ['GET'])]
    public function getAllDatasForAPI(TasksRepository $tasksRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $tasks = $tasksRepository->findAll();

            $json = $serializer->serialize($tasks, 'json', ['groups' => 'task_read']);

            return new JsonResponse($json, 200, [], true);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur s\'est produite',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/taskId/{id}', name: 'task_id', methods: ['GET'])]
    public function getUsersTask(TasksRepository $tasksRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        try {
            $tasks = $tasksRepository->findOneBy(['id' => $id]);

            $json = $serializer->serialize($tasks, 'json', ['groups' => 'task_users']);

            return new JsonResponse($json, 200, [], true);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur s\'est produite',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // #[Route('/team/{id}', name: 'team_id', methods: ['GET'])]
    // public function getTasksTeam(TasksRepository $tasksRepository, SerializerInterface $serializer, $id): JsonResponse
    // {
    //     try {
    //         $tasks = $tasksRepository->findOneBy(['id' => $id]);

    //         $json = $serializer->serialize($tasks, 'json', ['groups' => 'task_team']);

    //         return new JsonResponse($json, 200, [], true);
    //     } catch (\Exception $e) {
    //         return $this->json([
    //             'error' => "Une erreur s'est produite",
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    #[Route('createTask', name: 'create_task', methods: ['POST'])]
    public function createTask(EntityManagerInterface $manager, Request $request, AddressRepository $addressRepository, TeamRepository $teamRepository, SerializerInterface $serializer): Response
    {
        $data = $request->toArray();

        $startDate = $data["start_date"];
        $endDate = $data["end_date"];
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        $task = new Tasks();
        $task->setDescription($data["description"])
            ->setStartDate($startDateTime)
            ->setEndDate($endDateTime);

        $existingAddress = $addressRepository->findOneBy($data["address"]);

        if ($existingAddress) {
            $task->setAddress($existingAddress);
        } else {
            $address = new Address;
            $address->setWayNumber($data["address"]["way_number"])
                ->setAddressLabel($data["address"]["address_label"])
                ->setPostalCode($data["address"]["postal_code"])
                ->setCity($data["address"]["city"])
                ->setCountry($data["address"]["country"]);
            $task->setAddress($address);
        };

        $team = $teamRepository->findOneBy(['id' => $data["team"]["id"]]);

        if ($team) {
            $task->setTeam($team);
        };

        $manager->persist($task);
        $manager->flush();

        $json = $serializer->serialize($task, 'json', ['groups' => 'task_read']);
        return new JsonResponse($json, 201, [], true);
    }

    #[Route('updateTask/{id}', name: 'update_task', methods: ['PUT'])]
    public function updateTask(TasksRepository $tasksRepository, AddressRepository $addressRepository, Request $request, EntityManagerInterface $manager, SerializerInterface $serializer, $id): Response
    {
        $task = $tasksRepository->find($id);

        $data = $request->toArray();

        $startDate = $data["start_date"];
        $endDate = $data["end_date"];
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        $task->setDescription($data["description"])
            ->setStartDate($startDateTime)
            ->setEndDate($endDateTime);

        $existingAddress = $addressRepository->findOneBy($data["address"]);

        $address = $task->getAddress();

        if ($existingAddress) {
            $task->setAddress($existingAddress);
        } else {
            $address->setWayNumber($data["address"]["way_number"])
                ->setAddressLabel($data["address"]["address_label"])
                ->setPostalCode($data["address"]["postal_code"])
                ->setCity($data["address"]["city"])
                ->setCountry($data["address"]["country"]);
            $task->setAddress($address);
        };

        $manager->persist($task);
        $manager->flush();

        $json = $serializer->serialize($task, 'json', ['groups' => 'task_read']);
        return new JsonResponse($json, 201, [], true);
    }

    #[Route('deleteTask/{id}', name: 'delete_task', methods: ['DELETE'])]
    public function deleteTask(TasksRepository $tasksRepository, EntityManagerInterface $manager, $id, SerializerInterface $serializer)
    {
        $task = $tasksRepository->find($id);

        $interval = $task->getEndDate()->diff(new DateTime());

        if ($interval->days >= 60) {
            $manager->remove($task);
            $manager->flush();
            $task = null;
        } else {
            $task->setState(false);
            $manager->persist($task);
            $manager->flush();
        }

        if ($task) {
            $json = $serializer->serialize($task, 'json', ['groups' => 'task_read']);
            $response = new JsonResponse($json , 200, [], true);
        } else {
            $response = new JsonResponse(['status' => 'deleted'], 200, [],  false);
        }

        return $response;
    }
}
