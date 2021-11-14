<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");




class AccountController extends AbstractController
{
    // Route de récupération de tout les utilisateurs
    #[Route('/api/account', name: 'api_user_index', methods: ["GET", "POST"])]

    public function user(UserRepository $userRepository, Request $request): Response
    {
        $id = $request->getContent();

        return $this->json($userRepository->findOneByID($id), 200, []);
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

        return $this->json(['Utilisateur modifié'], 200, []);
    }
}
