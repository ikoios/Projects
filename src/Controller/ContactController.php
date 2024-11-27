<?php

namespace App\Controller;

use App\Entity\ContactList;
use App\Repository\ContactListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    public function getContatUsers(ContactListRepository $contactListRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $contactListRepository->findAll();

        $json = $serializer->serialize($users, 'json', ['groups' => 'contact_read']);

        return new JsonResponse($json, 200, [], true);
    }
}
