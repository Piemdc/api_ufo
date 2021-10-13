<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");




class ConnexionController extends AbstractController
{
    // Route de récupération de tout les utilisateurs
    #[Route('/api/user', name: 'api_user_index', methods: ["GET"])]

    public function user(UserRepository $userRepository): Response
    {

        return $this->json($userRepository->findAll(), 200, []);
    }


    // Route de récupération des articles
    #[Route('/api/article', name: 'api_article_index', methods: ["GET"])]

    public function article(ArticleRepository $ArticleRepository): Response
    {

        return $this->json($ArticleRepository->findAll(), 200, []);
    }

    // Route d'inscription

    #[Route('/api/signup', name: 'api_signup_index', methods: ["POST", "GET"])]

    public function signup(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->passwordHasher = $passwordHasher;
        $jsonpost = $request->getContent();
        $user = $serializer->deserialize($jsonpost, USER::class, 'json');
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->passwordHasher->hashPassword($user, true));
        $em->persist($user);
        $em->flush();

        return $this->json([''], 200, []);
    }

    // Route de connexion

    #[Route('/api/login', name: 'api_login_index', methods: ["POST", "GET"])]

    public function login(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $user): Response
    {
        $this->passwordHasher = $passwordHasher;

        $data = json_decode($request->getContent());
        $testUser = $data;
        $testUserName = $testUser->{'email'};
        $testPassword = $testUser->{'password'};
        $passwordIsValid = true;
        $userIsValid = false;

        if ($user->findOneByEmail($testUserName)) {
            $foundUser = $user->findOneByEmail($testUserName);
            $userIsValid = true;
            if ($passwordHasher->isPasswordValid($foundUser, $testPassword)) {

                $passwordIsValid = true;
            };
        };
        dump($foundUser);

        dump($testPassword);


        $userIsValid && $passwordIsValid ? $response = $this->json([$foundUser], 200, []) :   $response = $this->json([$userIsValid, $passwordIsValid], 400, []);

        return $response;
    }
}
