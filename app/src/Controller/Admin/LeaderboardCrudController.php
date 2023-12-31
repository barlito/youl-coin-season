<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Leaderboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class LeaderboardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Leaderboard::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT, Action::DELETE)
        ;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            CollectionField::new('userScores')
                ->renderExpanded()
                ->setEntryIsComplex()
                ->showEntryLabel()
                ->useEntryCrudForm(UserScoreCrudController::class)
                ->showEntryLabel()
                ->formatValue(function ($value, $entity) {
                    if (!$entity instanceof Leaderboard) {
                        throw new UnexpectedTypeException($entity, Leaderboard::class);
                    }

                    $userPoints = $entity->getUserScores()->getIterator();
                    $userPoints->uasort(function ($a, $b) {
                        return $a->getScore() <=> $b->getScore();
                    });

                    $string = '';
                    foreach ($userPoints as $userPoint) {
                        $string .= $userPoint->getDiscordUserId() . ' : ' . $userPoint->getScore() . '<br>';
                    }

                    return $string;
                }),
            AssociationField::new('season'),
        ];
    }
}
