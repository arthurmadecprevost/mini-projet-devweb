<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Commentaire;
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
        $user->setPrenom('Matthias');
        $user->setNom('Robert');
        $user->setDateNaissance(new \DateTime('NOW'));
        $user->setEmail('admin@admin.fr');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin'));
        $manager->persist($user);


        $user2 = new Membre();
        $user2->setPrenom('Jean');
        $user2->setNom('Valjean');
        $user2->setDateNaissance(new \DateTime("1999-01-01 16:00:00"));
        $user2->setEmail('jean@valjean.fr');
        $user2->setPassword($this->passwordEncoder->encodePassword($user2,'jeanvaljean'));
        $manager->persist($user2);

        $user3 = new Membre();
        $user3->setPrenom('Pierre');
        $user3->setNom('Dupont');
        $user3->setDateNaissance(new \DateTime("1999-01-01 16:00:00"));
        $user3->setEmail('pierre@dupont.fr');
        $user3->setPassword($this->passwordEncoder->encodePassword($user3,'pierredupont'));
        $manager->persist($user3);

        $categorie = new Categorie();
        $categorie->setNom('Sport');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Tennis');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement de Tennis');
        $event->setLieu('Nantes');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);

        $annonce = new Annonce();
        $annonce->setTitre('A ne pas oublier...');
        $annonce->setContenu('Noubliez surtout pas vos raquettes...');
        $annonce->setAuteur($event->getOrganisateur());
        $annonce->setDatePublication(new \DateTime("2022-01-01 17:00:00"));
        $annonce->setEvenement($event);
        $manager->persist($annonce);


        $categorie = new Categorie();
        $categorie->setNom('Cinéma');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Avengers');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement de Avengers');
        $event->setLieu('Nantes');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user2);
        $manager->persist($event);

        $annonce = new Annonce();
        $annonce->setTitre('Merci de respecter les gestes barrières');
        $annonce->setContenu('2022 est certes un peu loin, mais je préviens direct: respectez la distanciation sociale !!! et le silence dans la salle svp');
        $annonce->setAuteur($event->getOrganisateur());
        $annonce->setDatePublication(new \DateTime("2022-01-01 18:00:00"));
        $annonce->setEvenement($event);
        $manager->persist($annonce);

        $commentaire = new Commentaire();
        $commentaire->setAuteur($user);
        $commentaire->setEvenement($event);
        $commentaire->setContenu('Trop bien mais Iron Man est déjà mort');
        $commentaire->setDate(new \DateTime("2021-01-01 18:30:00"));
        $manager->persist($commentaire);

        $commentaire = new Commentaire();
        $commentaire->setAuteur($user3);
        $commentaire->setEvenement($event);
        $commentaire->setContenu('Ca se fait pas de spoiler comme ça...');
        $commentaire->setDate(new \DateTime("2021-01-01 18:35:00"));
        $manager->persist($commentaire);

        $categorie = new Categorie();
        $categorie->setNom('Théatre');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Le malade imaginaire');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement du Malade Imaginaire');
        $event->setLieu('Bordeaux');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user3);
        $manager->persist($event);

        $annonce = new Annonce();
        $annonce->setTitre('Merci de ramener vos mouchoirs personnels');
        $annonce->setContenu('La pièce de Théatre étant réputée comme très triste, nous vous conseillons damener vos mouchoirs');
        $annonce->setAuteur($event->getOrganisateur());
        $annonce->setDatePublication(new \DateTime('NOW'));
        $annonce->setEvenement($event);
        $manager->persist($annonce);

        $commentaire = new Commentaire();
        $commentaire->setAuteur($user2);
        $commentaire->setEvenement($event);
        $commentaire->setContenu('Trop bien, jy serais directement, cest ma pièce préférée!!!!!!!!!!!!!!!!!!!!!!!!!');
        $commentaire->setDate(new \DateTime("2021-01-01 18:30:00"));
        $manager->persist($commentaire);

        $categorie = new Categorie();
        $categorie->setNom('Restaurant');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Macdo');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement Restaurant');
        $event->setLieu('Bordeaux');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user2);
        $manager->persist($event);

        $annonce = new Annonce();
        $annonce->setTitre('Il n y aura pas de BigMac !');
        $annonce->setContenu('On a perdu tous les pains BigMac désolé les amis');
        $annonce->setAuteur($event->getOrganisateur());
        $annonce->setDatePublication(new \DateTime("2022-01-01 19:00:00"));
        $annonce->setEvenement($event);
        $manager->persist($annonce);

        $categorie = new Categorie();
        $categorie->setNom('Soirée');
        $manager->persist($categorie);

        $event = new Evenement();
        $event->setLibelle('Soirée étudiante');
        $event->setDate(new \DateTime("2022-01-01 16:00:00"));
        $event->setDescription('Evenement soirée étudiante');
        $event->setLieu('Toulouse');
        $event->setNbParticipantsMax(mt_rand(10, 100));
        $event->setPrix(mt_rand(1, 50));
        $event->setCategory($categorie);
        $event->setOrganisateur($user);
        $manager->persist($event);

        $manager->flush();
    }
}
