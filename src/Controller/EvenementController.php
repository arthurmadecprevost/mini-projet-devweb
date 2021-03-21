<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Form\CommentaireType;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/evenements", name="evenement.list")
     */
    public function list(): Response
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findAll();

        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenements' => $evenements,
        ]);
    }

    /**
     * @Route("/evenement/{id}", name="event")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function show($id, Request $request, EntityManagerInterface $em): Response
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(array('id' => $id));
        $commentaire = new Commentaire();
        $user = $this->getUser();
        $commentaire->setAuteur($user);
        $commentaire->setEvenement($evenement);
        $commentaire->setDate(new \DateTime('now'));
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commentaire);
            $em->flush();
        }
        return $this->render('evenement/event.html.twig', [
            'event'=>$evenement,
            'commentaire' => $form->createView()
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $evenement = new Evenement();
        $user = $this->getUser();
        $evenement->setOrganisateur($user);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenement.list');
        }
        return $this->render('evenement/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifier un evenement.
     * @Route("/modifier-evenement/{id}", name="evenement.edit")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function edit(Request $request,$id, EntityManagerInterface $em) : Response
    {

        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('evenement.list');
        }
        return $this->render('evenement/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Supprimer un evenement.
     * @Route("/evenement-delete/{id}", name="evenement.delete")
     * @param Request $request
     * @param Evenement $evenement
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function delete(Request $request, $id, EntityManagerInterface $em) : Response
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement.delete', ['id'=>$id]))
            ->getForm();
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('evenement.list');
    }
    /**
     * Filtrer un evenement.
     * @Route("/rechercheParCategorie", name="eventByCat")
     */
    public function searchByCategory(Request $request)
    {
        $formSearch = $this->createFormBuilder()
            ->add('category', EntityType::class, [
                'class' => Categorie::class,
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();
        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted()) {  //ce code est exécuté lors de la soumission du formulaire
            $categorie = $formSearch->getData()['category'];
            return $this->redirectToRoute('evenementByCat',['category' => ($categorie->getId())]);
        }
        return $this->render('evenement/filtre.html.twig', [
            'formSearch' => $formSearch->createView()]);
    }

    /**
     * @Route("/commentairesByEvent/{id}", name="commentairesByEvent")
     */
    public function commentairesByEvent($id): Response
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $commentaire = $evenement->getCommentaires();
        return $this->render('commentaires/list.html.twig', [
            'commentaires' => $commentaire,
        ]);
    }
    /**
     * @Route("/evenements/{id}/categorie", name="evenementByCat")
     */
    public function afficherEvenementsByCat($id)
    {
        $evenements = $this->getDoctrine()->getRepository(Evenement::class)->findOneBy(array('category' => $id));
        return $this->render('evenement/index.html.twig',[
            'evenements' => $evenements
        ]);
    }
}
