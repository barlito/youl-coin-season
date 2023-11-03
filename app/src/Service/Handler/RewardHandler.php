<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\Entity\Reward;
use App\Repository\UserScoreRepository;
use App\Service\Handler\Abstraction\AbstractHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RewardHandler extends AbstractHandler
{
    public function __construct(
        private readonly UserScoreRepository $userScoreRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ) {
        parent::__construct($entityManager, $validator);
    }

    public function handleReward(Reward $reward)
    {
        $userScores = array_filter(
            $reward->getSeason()->getLeaderboard()->getUserScores()->toArray(),
            static fn ($userScore) => $userScore->getRank() === $reward->getRank(),
        );

        if (\count($userScores) > 1) {
            // todo send a notification, we have a draw, let's do a duel
            return;
        }

        // todo find the right service by the reward type to send the reward to the user through API call

        dd($userScores);
    }
}
