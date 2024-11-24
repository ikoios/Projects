<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
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

    #[Route('/team/{id}', name: 'team_id', methods: ['GET'])]
    public function getTasksTeam(TasksRepository $tasksRepository, SerializerInterface $serializer, $id): JsonResponse
    {
        try {
            $tasks = $tasksRepository->findOneBy(['id' => $id]);

            $json = $serializer->serialize($tasks, 'json', ['groups' => 'task_team']);

            return new JsonResponse($json, 200, [], true);
        } catch (\Exception $e) {
            return $this->json([
                'error' => "Une erreur s'est produite",
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /*

    j'attend un objet du type JSON : 

    
    {
        "description": "faire un test",
        "start_date": "2024-11-23T18:09:53+00:00",
        "end_date": "2024-11-24T18:09:53+00:00",
        "state": true,
        "address": {
            "way_number": 1,
            "address_label": "rue du test",
            "postal_code": 59000,
            "city": "Lille",
            "country": "France"
         },
    }


    */
    #[Route('createTasks', name: 'create_tasks', methods: ['POST'])]
    public function createTasks(EntityManagerInterface $manager, Request $request, SerializerInterface $serializer): Response
    {
        $description = $request->query->get('description');
        $sDate = $request->query->get('name');
        $eDate = $request->query->get('name');
        $addr = $request->query->get('name');

        $task = new Tasks();

        $task->setDescription($request->query->get('description'));
        dd($task->getDescription());
        $task->setStartDate('data start date');
        $task->setEndDate('data end Date');
        // verification de ladresse si celle n'existe pas 
        // si elle existe je ratache ladresse existante a la tache SINON je la creer 
        $task->setAddress('data Adresse');
        $manager->persist($task);
        $manager->flush();


        return '';
    }
}
