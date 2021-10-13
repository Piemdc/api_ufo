<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user->setPseudo("pseudo$i", $i);
            $user->setNom("nom$i", $i);
            $user->setPrenom("prenom$i", $i);
            $user->setEmail("prenom$i@$i.us");
            $user->setPassword($this->passwordHasher->hashPassword('test', 'pass_1234'));
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }




        $manager->flush();
    }
}
