<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Reward;
use App\Enum\RankEnum;
use App\Enum\RewardTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class RewardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reward::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::INDEX, Action::DETAIL, Action::NEW, Action::EDIT, Action::DELETE)
        ;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')
                ->setFormType(EnumType::class)
                ->setFormTypeOption('class', RewardTypeEnum::class),
            'amount',
            ChoiceField::new('rank')
                ->setFormType(EnumType::class)
                ->setFormTypeOption('class', RankEnum::class),
            'externalId',
            TextField::new('externalId')
                ->setHelp('externalId of the card or the booster pack'),
        ];
    }
}
