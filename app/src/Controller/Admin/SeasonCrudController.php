<?php

namespace App\Controller\Admin;

use App\Entity\Leaderboard;
use App\Entity\Reward;
use App\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SeasonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Season::class;
    }

    public function configureFields(string $pageName): iterable
    {

//        yield AssociationField::new('leaderboard')->setCrudController(LeaderboardCrudController::class);


        return [
            'name',
            'dateStart',
            'dateEnd',
            CollectionField::new('rewards')
                ->renderExpanded()
                ->setEntryIsComplex()
                ->showEntryLabel()
                ->useEntryCrudForm(RewardCrudController::class)
                ->showEntryLabel(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(['name']);
    }

    protected function getRedirectResponseAfterSave(AdminContext $context, string $action): RedirectResponse
    {
        $submitButtonName = $context->getRequest()->request->all()['ea']['newForm']['btn'];

        if ('saveAndViewDetail' === $submitButtonName) {
            $url = $this->container->get(AdminUrlGenerator::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($context->getEntity()->getPrimaryKeyValue())
                ->generateUrl();

            return $this->redirect($url);
        }

        return parent::getRedirectResponseAfterSave($context, $action);
    }
}
