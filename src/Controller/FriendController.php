<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ContactlistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FriendController extends AbstractController
{
    #[Route('/api/friends/{id}', name: 'api_friends_index', methods: ["GET"])]
    public function index(int $id, UserRepository $UserRepository, ContactlistRepository $ContactlistRepository, SerializerInterface $serializer): Response
    {
        $getList = $ContactlistRepository->findFriends($id);
        dump($getList);
        $friends = $serializer->serialize($getList, 'json',  ['groups' => 'contact:read']);


        return new JsonResponse($friends, 200, [], true);
    }
}
