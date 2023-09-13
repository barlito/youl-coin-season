<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\UserScore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserScoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserScore::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::INDEX, Action::DETAIL, Action::NEW, Action::EDIT, Action::DELETE)
        ;
    }
}
