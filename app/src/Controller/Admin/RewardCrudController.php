<?php

namespace App\Controller\Admin;

use App\Entity\Reward;
use App\Enum\RewardStatusEnum;
use App\Enum\RewardTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class RewardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reward::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            ChoiceField::new('type')
                ->setFormType(EnumType::class)
                ->setFormTypeOption('class', RewardTypeEnum::class),
            IntegerField::new('amount'),
        ];
    }
}
