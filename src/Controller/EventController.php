<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Evenement;
use App\Repository\UserRepository;
use App\Repository\EvenementRepository;
use App\Repository\BesoinRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;




class EventController extends AbstractController
{



    // Route de recuperation d'événement

    #[Route('/api/event', name: 'api_event_index', methods: ["POST", "GET"])]

    public function getEvent(Request $request, EvenementRepository $evenementRepository, SerializerInterface $serializer): Response
    {

        $id = json_decode($request->getContent());
        $id = $id->event;

        $getevent = $evenementRepository->findByID($id);

        $event = $serializer->serialize($getevent, 'json',  ['groups' => 'evenement:read']);


        return new JsonResponse($event, 200, [], true);
    }

    // Route de creation d'événement

    #[Route('/api/newevent', name: 'api_event_creator', methods: ["POST", "GET"])]

    public function createEvent(Request $request, UserRepository $userRepository, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $jsonpost = $request->getContent();

        $event = $serializer->deserialize($jsonpost, Evenement::class, 'json');
        $creator = json_decode($jsonpost)->creator;
        $creator = $userRepository->findOneByUsername($creator);
        $event->setIcone(1);
        $event->setCreatorID($creator);
        $em->persist($event);
        $em->flush();

        $NewEvent = $serializer->serialize($event, 'json',  ['groups' => 'evenement:read']);

        return new JsonResponse($NewEvent, 200, [], true);
    }


    //Route de modification d'un event
    #[Route('/api/modifyevent/{id}', name: 'api_event_modify', methods: ["GET", "POST"])]

    public function modifyevent(int $id, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $findevent = $em->getRepository(Evenement::class)->find($id);

        if (!$findevent) {
            throw $this->createNotFoundException(
                'Aucun utilisateur trouvé pour l\'id= ' . $id
            );
        }

        $jsonpost = $request->getContent();
        $event = $serializer->deserialize($jsonpost, Evenement::class, 'json');
        $findevent->setAdresse($event->getAdresse());
        $findevent->setNom($event->getNom());
        $findevent->setDetails($event->getDetails());

        $findevent->setDate($event->getDate());

        $em->flush();

        return $this->json(['evenement modifié'], 200, ['groups' => 'evenement:wright']);
    }

    // Route de récupération des besoins
    #[Route('/api/need', name: 'api_need_index', methods: ["POST", "GET"])]

    public function getNeed(Request $request, BesoinRepository $besoinRepository, SerializerInterface $serializer): Response
    {

        $id = json_decode($request->getContent());
        $id = $id->event;
        $getneed = $besoinRepository->findByEvent($id);

        $need = $serializer->serialize($getneed, 'json',  ['groups' => 'need:read']);


        return new JsonResponse($need, 200, [], true);
    }
}
