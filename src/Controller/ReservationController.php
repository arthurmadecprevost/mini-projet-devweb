<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    /**
     * @Route("/reserver/{id}", name="reserver")
     */
    public function reserver($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $reservation = new Reservation();
        $user = $this->getUser();
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);

        $reservation->setEvent($evenement);
        $reservation->setMembre($user);

        $entityManager->persist($reservation);

        $entityManager->flush();

        $this->addFlash('success', 'L\'événement '.$evenement->getLibelle().' a bien été réservé');
        return $this->redirectToRoute('evenement.list');
    }
}
