<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route({
     *     "en": "/my-reservations",
     *     "fr": "/mes-reservations"
     * }, name="myreservation")
     */
    public function myReservation(): Response
    {
        $reservations = $this->getUser()->getReservations();
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations
        ]);
    }
    /**
     * @Route({
     *     "en": "/book/{id}",
     *     "fr": "/reserver/{id}"
     * }, name="reserver")
     */
    public function reserver($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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

    /**
     * Supprimer une reservation.
     * @Route({
     *     "en": "/delete-reservation/{id}",
     *     "fr": "/supprimer-reservation/{id}"
     * }, name="reservation.delete")
     * @param Reservation $reservation
     * @return Response
     */
    public function deleteReservation($id) : Response
    {
        $reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('myreservation');
    }
}
