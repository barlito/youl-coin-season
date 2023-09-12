<?php

namespace App\Controller\Admin;

use App\Entity\UserPoints;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserPointsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserPoints::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::INDEX, Action::DETAIL, Action::NEW, Action::EDIT, Action::DELETE)
            ;
    }
}
