<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Evenement;
use App\Form\AnnonceType;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonces")
     */
    public function index(): Response
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();

        return $this->render('index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /**
     * Créer une nouvelle annonce.
     * @Route("/nouvelle-annonce", name="annonce.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */

    public function create(Request $request, EntityManagerInterface $em) : Response {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('annonces');
        }
        return $this->render('annonce/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
