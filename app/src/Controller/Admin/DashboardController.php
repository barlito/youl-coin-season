<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Leaderboard;
use App\Entity\Season;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(SeasonCrudController::class)->generateUrl());

        // return some charts of the current Season and some stuff here instead of the Season dashboard
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('YC Season Admin')
            ->setFaviconPath('https://media.discordapp.net/attachments/1115998429970169876/1116449043523059813/YTCG.png?width=676&height=676')
            ->renderContentMaximized()
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Settings');
        yield MenuItem::linkToCrud('Seasons', 'fas fa-calendar-days', Season::class);
        yield MenuItem::linkToCrud('Leaderboards', 'fa-solid fa-ranking-star', Leaderboard::class);

        yield MenuItem::section('Extra');
        // Todo set link here
        yield MenuItem::linkToUrl('YTCG - Admin', 'fa-brands fa-wizards-of-the-coast', 'https://google.com');
        yield MenuItem::linkToUrl('YC Exchange - Admin', 'fas fa-wallet', '');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setTimezone('Europe/Paris')
        ;
    }
}
