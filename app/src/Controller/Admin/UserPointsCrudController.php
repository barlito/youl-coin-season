<?php

namespace App\Controller\Admin;

use App\Entity\UserPoints;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserPointsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserPoints::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
