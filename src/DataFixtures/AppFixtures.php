<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Evenement;
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
            $user->setDateNaissance(new \DateTime("1999-01-01 16:00:00"));
            $user->setEmail($i.'@user.fr');
            $user->setPassword($this->passwordEncoder->encodePassword($user,'membre'.$i));
            $manager->persist($user);
        }
        $categorie = new Categorie();
        $categorie->setNom('Sport');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Tennis');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement '.$i);
        $event->setLieu('Nantes');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);


        $categorie = new Categorie();
        $categorie->setNom('Cinéma');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Avengers');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement '.$i);
        $event->setLieu('Nantes');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);


        $categorie = new Categorie();
        $categorie->setNom('Théatre');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Le malade imaginaire');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement '.$i);
        $event->setLieu('Bordeaux');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);



        $categorie = new Categorie();
        $categorie->setNom('Restaurant');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Macdo');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement '.$i);
        $event->setLieu('Bordeaux');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);



        $categorie = new Categorie();
        $categorie->setNom('Soirée');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Soirée étudiante');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement '.$i);
        $event->setLieu('Toulouse');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);

        $manager->flush();
    }
}
