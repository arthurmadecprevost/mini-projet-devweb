<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenements", name="events")
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenements' => $evenements,
        ]);
    }

    /**
     * Créer un nouvel evenement.
     * @Route("/nouvel-evenement", name="evenement.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */

    public function create(Request $request, EntityManagerInterface $em) : Response {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('events');
        }
        return $this->render('evenement/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
