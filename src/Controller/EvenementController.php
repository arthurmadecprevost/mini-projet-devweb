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
     */
    public function show($id): Response
    {
        $evenement = $this->getDoctrine()->getRepository(Evenement::class)->findOneById($id);

        return $this->render('evenement/event.html.twig', [
            'event'=>$evenement,
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

}
