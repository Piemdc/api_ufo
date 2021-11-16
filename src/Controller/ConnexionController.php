<?php

namespace App\Controller;


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




class ConnexionController extends AbstractController
{

    // Route d'inscription

    #[Route('/api/signup', name: 'api_signup_index', methods: ["POST", "GET"])]

    public function signup(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $this->passwordEncoder = $passwordEncoder;
        $jsonpost = $request->getContent();
        $user = $serializer->deserialize($jsonpost, USER::class, 'json');
        $newPassword = $user->getPassword();
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(["ROLE_USER"]);
        $user->setAvatar("1.png");
        $user->setPassword($this->passwordEncoder->encodePassword($user, $newPassword));
        $em->persist($user);
        $em->flush();

        return $this->json(['Utilisateur inscrit'], 200, []);
    }


    //  Route de connexion

    #[Route('/api/login', name: 'api_login', methods: ["POST", "GET"])]
    public function login(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {


        return $this->json(
            [
                'user' => $this->getUser()->getId()
            ]
        );
    }
}
