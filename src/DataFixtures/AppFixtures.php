<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Membre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $categorie = new Categorie();
            $categorie->setNom('Catégorie '.$i);
            $manager->persist($categorie);
        }

        $user = new Membre();
        $user->setPrenom('Jean');
        $user->setNom('Admin');
        $user->setDateNaissance(new \DateTime('NOW'));
        $user->setEmail('admin@admin.fr');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin'));
        $manager->persist($user);




        $manager->flush();

    }
}
