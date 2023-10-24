<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Season;
use App\Enum\Workflow\SeasonWorkflowEnum;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'app:season:finish',
    description: 'Command to find and finish Seasons',
)]
class SeasonFinishCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly SeasonRepository $seasonRepository,
        private readonly WorkflowInterface $seasonStateMachine,
    ) {
        parent::__construct('Season Finish Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $season = $this->seasonRepository->findFinishedSeasons();
        } catch (NonUniqueResultException $exception) {
            $output->writeln($exception->getMessage());

            return Command::FAILURE;
        }

        if (null === $season) {
            return Command::SUCCESS;
        }

        $io->info('Finish Season : ' . $season->getName() . ' | ' . $season->getId());
        $this->seasonStateMachine->apply($season, SeasonWorkflowEnum::FINISH->value);

        $violations = $this->validate($season, $io);

        if ($violations->count() > 0) {
            return Command::SUCCESS;
        }

        $this->entityManager->persist($season);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }

    private function validate(Season $season, SymfonyStyle $io): ConstraintViolationListInterface
    {
        $violations = $this->validator->validate($season);
        if ($violations->count() > 0) {
            $io->error('Season ' . $season->getId() . ' is not valid');
            foreach ($violations as $violation) {
                $io->error($violation->getMessage());
            }
        }

        return $violations;
    }
}
