<?php

namespace App\EventSubscriber;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['addUser'],
            BeforeEntityUpdatedEvent::class => ['updateUser'], //surtout utile lors d'un reset de mot passe plutôt qu'un réel update, car l'update va de nouveau encrypter le mot de passe DEJA encrypté ...
        ];
    }

    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Membre)) {
            return;
        }
        $this->setPassword($entity);
    }

    public function addUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Membre)) {
            return;
        }
        $this->setPassword($entity);
    }

    /**
     * @param Membre $entity
     */
    public function setPassword(Membre $entity): void
    {
        $pass = $entity->getPassword();

        $entity->setPassword(
            $this->passwordEncoder->encodePassword(
                $entity,
                $pass
            )
        );
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}