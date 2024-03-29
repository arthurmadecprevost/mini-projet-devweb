<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Form\CommentaireType;
use App\Form\EvenementType;
use App\Form\SearchType;
use App\Repository\EvenementRepository;
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
     * @Route({
     *     "en": "/events",
     *     "fr": "/evenements"
     * }, name="evenement.list")
     */
    public function list(EvenementRepository $repository, Request $request)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $events = $repository->findSearch($data);
        return $this->render('evenement/index.html.twig', [
            'evenements' => $events,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route({
     *     "en": "/event/{id}",
     *     "fr": "/evenement/{id}"
     * }, name="event")
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
     * @Route({
     *     "en": "/new-event",
     *     "fr": "/nouvel-evenement"
     * }, name="evenement.create")
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
     * @Route({
     *     "en": "/edit-event/{id}",
     *     "fr": "/modifier-evenement/{id}"
     * }, name="evenement.edit")
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
     * @Route({
     *     "en": "/delete-event/{id}",
     *     "fr": "/supprimer-evenement/{id}"
     * }, name="evenement.delete")
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
        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            return $this->render('evenement/delete.html.twig', [
                'evenement' => $evenement,
                'form' => $form->createView(),
            ]);
        }
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
            ->add('filterByCat', EntityType::class, [
                'class' => Categorie::class,
                'label_format' => '%name%',
                'attr' => ['class' => 'form-control']
            ])
            ->add('filter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
                'label_format' => '%name%',
            ])
            ->getForm();
        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted()) {  //ce code est exécuté lors de la soumission du formulaire
            $categorie = $formSearch->getData()['category'];
            return $this->redirectToRoute('evenementByCat',['id' => ($categorie->getId())]);
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
    /**
     * @Route({
     *     "en": "/my-events",
     *     "fr": "/mes-evenements"
     * }, name="myevent")
     */
    public function myEvent(): Response
    {
        $events = $this->getUser()->getMesevenements();
        return $this->render('evenement/myevent.html.twig', [
            'events' => $events
        ]);
    }
}
