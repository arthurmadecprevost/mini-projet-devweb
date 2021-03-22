<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Entity\Membre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mini Projet Devweb');
    }

    public function configureMenuItems(): iterable
    {
        return [
            // ...

            MenuItem::section('Catégories'),
            // links to the 'index' action of the Category CRUD controller
            MenuItem::subMenu('Categories', 'fa fa-bookmark')->setSubItems([
                MenuItem::linkToCrud('Categories', 'fa fa-tags', Categorie::class),
                MenuItem::linkToCrud('Ajouter Categorie', 'fa fa-tags', Categorie::class)
                    ->setAction('new'),
            ]),
            // links to a different CRUD action
            MenuItem::section('Membres'),
            // links to the 'index' action of the Category CRUD controller
            MenuItem::linkToCrud('Membres', 'fa fa-tags', Membre::class),
            MenuItem::linkToCrud('Evenements', 'fa fa-tags', Evenement::class),
            // links to a different CRUD action
            MenuItem::linkToCrud('Ajouter Membre', 'fa fa-tags', Membre::class)
                ->setAction('new'),
        ];
    }
}
