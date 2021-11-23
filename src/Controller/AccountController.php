<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");




class AccountController extends AbstractController
{
    // Route de récupération d'un utilisateur
    #[Route('/api/account', name: 'api_user_index', methods: ["GET", "POST"])]

    public function user(UserRepository $userRepository, SerializerInterface $serializer, Request $request): Response
    {
        $id = json_decode($request->getContent());
        $id = $id->user;
        $getuser = $userRepository->findOneByID($id);
        $user = $serializer->serialize($getuser, 'json',  ['groups' => 'user:read']);


        return new JsonResponse($user, 200, [], true);
    }


    //Route de modification d'un utilisateur
    #[Route('/api/updateAccount/{id}', name: 'api_user_update', methods: ["GET", "POST"])]

    public function update(int $id, Request $request, EntityManagerInterface $em, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $finduser = $em->getRepository(User::class)->find($id);

        if (!$finduser) {
            throw $this->createNotFoundException(
                'Aucun utilisateur trouvé pour l\'id= ' . $id
            );
        }

        $this->passwordEncoder = $passwordEncoder;
        $jsonpost = $request->getContent();
        $user = $serializer->deserialize($jsonpost, USER::class, 'json');
        $newPassword = $user->getPassword();
        $finduser->setEmail($user->getEmail());
        $finduser->setPseudo($user->getPseudo());
        $finduser->setNom($user->getNom());
        $finduser->setPrenom($user->getPrenom());
        $finduser->setPassword($this->passwordEncoder->encodePassword($user, $newPassword));
        $em->flush();

        return $this->json(['Utilisateur modifié'], 200, ['groups' => 'user:wright']);
    }

    // Récupération de la liste des evenements 
    #[Route('/api/eventlist/{id}', name: 'api_event_list', methods: ["GET", "POST"])]

    public function eventslist(int $id, EvenementRepository $evenementRepository, SerializerInterface $serializer): Response
    {
        $getevent = $evenementRepository->findByCreatorID($id);
        $events = $serializer->serialize($getevent, 'json',  ['groups' => 'evenement:read']);


        return new JsonResponse($events, 200, [], true);
    }
}
