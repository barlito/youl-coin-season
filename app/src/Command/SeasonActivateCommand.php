<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\Workflow\SeasonWorkflowEnum;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

#[AsCommand(
    name: 'app:season:activate',
    description: 'Command to find and activate Seasons',
)]
class SeasonActivateCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface $validator,
        private readonly SeasonRepository $seasonRepository,
        private readonly WorkflowInterface $seasonStateMachine,
    ) {
        parent::__construct('Season Active Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $seasons = $this->seasonRepository->findActivableSeasons();

        foreach ($seasons as $season) {
            $io->info('Activate Season : ' . $season->getName() . ' | ' . $season->getId());
            $this->seasonStateMachine->apply($season, SeasonWorkflowEnum::ACTIVATE->value);

            $violations = $this->validator->validate($season);
            if ($violations->count() > 0) {
                $io->error('Season ' . $season->getId() . ' is not valid');
                foreach ($violations as $violation) {
                    $io->error($violation->getMessage());
                }
                $this->entityManager->detach($season);
                continue;
            }
            $this->entityManager->persist($season);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
