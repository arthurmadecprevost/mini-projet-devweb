<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Form\CommentaireType;
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

class CommentairesController extends AbstractController
{
    /**
     * @Route("/commentaires", name="commentaires")
     */
    public function index(): Response
    {
        return $this->render('commentaires/index.html.twig', [
            'controller_name' => 'CommentairesController',
        ]);
    }
    /**
     * @Route("/evenements/{id}", name="commentiares.list")
     */
    public function list(): Response
    {
        $commentaires = $this->getDoctrine()->getRepository(commentaires::class)->findAll();

        return $this->render('evenement/event.html.twig', [
            'controller_name' => 'CommentairesController',
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * Créer un nouveau commentaire.
     * @Route("/evenements/{id}", name="commentaire.create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */

    public function create(Request $request, EntityManagerInterface $em) : Response {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('evenement.list');
        }
        return $this->render('evenement/event.html.twig', [
            'formCommentaire' => $form->createView(),
        ]);
    }
}
