<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\RewardRepository;
use App\Service\Handler\RewardHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:reward:distribution',
    description: 'This command give rewards to users based on their rank in the leaderboard for closed seasons and unclaimed rewards',
)]
class RewardCommand extends Command
{
    public function __construct(
        private readonly RewardRepository $rewardRepository,
        private readonly RewardHandler $rewardHandler,
    ) {
        parent::__construct('Reward Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $rewards = $this->rewardRepository->findUnclaimedRewardsFromClosedSeasons();

        foreach ($rewards as $reward) {
            $io->info('Processing Reward : ' . $reward->getId() . ' | Rank : ' . $reward->getRank());
            $this->rewardHandler->handleReward($reward);
        }

        return Command::SUCCESS;
    }
}
