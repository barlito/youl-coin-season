<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Season;
use App\Enum\SeasonStatusEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class SeasonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            'name',
            'dateStart',
            'dateEnd',
            ChoiceField::new('status')
                ->setFormType(EnumType::class)
                ->setFormTypeOption('class', SeasonStatusEnum::class)
                ->hideOnForm(),
            CollectionField::new('rewards')
                ->renderExpanded()
                ->setEntryIsComplex()
                ->showEntryLabel()
                ->useEntryCrudForm(RewardCrudController::class)
                ->showEntryLabel(),
            AssociationField::new('leaderboard')->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['name'])
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE)
        ;
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if ('saveAndViewDetail' === $submitButtonName) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($context->getEntity()->getPrimaryKeyValue())
                ->generateUrl()
            ;

            return $this->redirect($url);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }
}
