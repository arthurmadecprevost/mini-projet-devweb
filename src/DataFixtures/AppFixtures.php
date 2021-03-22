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
        $categorie = new Categorie();
        $categorie->setNom('Sport');
        $manager->persist($categorie);
        $categorie = new Categorie();
        $categorie->setNom('Cinéma');
        $manager->persist($categorie);
        $categorie = new Categorie();
        $categorie->setNom('Théatre');
        $manager->persist($categorie);
        $categorie = new Categorie();
        $categorie->setNom('Restaurant');
        $manager->persist($categorie);
        $categorie = new Categorie();
        $categorie->setNom('Soirée');
        $manager->persist($categorie);

        $user = new Membre();
        $user->setPrenom('Jean');
        $user->setNom('Admin');
        $user->setDateNaissance(new \DateTime('NOW'));
        $user->setEmail('admin@admin.fr');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin'));
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $user = new Membre();
            $user->setPrenom('Membre '.$i);
            $user->setNom('Default');
            $user->setDateNaissance(new \DateTime('NOW'));
            $user->setEmail($i.'@user.fr');
            $user->setPassword($this->passwordEncoder->encodePassword($user,'membre'.$i));
            $manager->persist($user);
        }



        $manager->flush();

    }
}
