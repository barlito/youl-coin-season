<?php

declare(strict_types=1);

namespace App\Service\Messenger\Handler;

use App\DTO\Messenger\TransactionDTO;
use App\DTO\Messenger\WalletDTO;
use App\Entity\Leaderboard;
use App\Entity\Season;
use App\Entity\UserScore;
use App\Enum\SeasonStatusEnum;
use App\Repository\SeasonRepository;
use App\Repository\UserPointsRepository;
use App\Service\Handler\Abstraction\AbstractHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler]
class TransactionNotificationMessageHandler extends AbstractHandler
{
    public function __construct(
        private readonly SeasonRepository $seasonRepository,
        private readonly UserPointsRepository $userPointsRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
    ) {
        parent::__construct($entityManager, $validator);
    }

    public function __invoke(TransactionDTO $transactionNotificationMessage): void
    {
        $this->validate($transactionNotificationMessage);

        $season = $this->seasonRepository->findOneBy(['status' => SeasonStatusEnum::ACTIVE]);
        if (!$season instanceof Season) {
            return;
        }

        $this->handleWalletFromPoints($transactionNotificationMessage->getWalletFrom(), $transactionNotificationMessage->getAmount(), $season->getLeaderboard());
        $this->handleWalletTo($transactionNotificationMessage->getWalletTo(), $transactionNotificationMessage->getAmount(), $season->getLeaderboard());

        $this->entityManager->flush();
    }

    private function handleWalletFromPoints(WalletDTO $wallet, string $transactionAmount, Leaderboard $leaderboard): void
    {
        if (null === $wallet->getDiscordUser()) {
            return;
        }

        $userScore = $this->userPointsRepository->findOneBy(['discordUserId' => $wallet->getDiscordUser()->getDiscordId()]);

        if (!$userScore instanceof UserScore) {
            $userScore = (new UserScore())
                ->setDiscordUserId($wallet->getDiscordUser()->getDiscordId())
                ->setLeaderboard($leaderboard)
            ;
        }

        $userScore->setScore(bcsub($userScore->getScore(), $transactionAmount));

        $this->entityManager->persist($userScore);
    }

    private function handleWalletTo(WalletDTO $wallet, string $transactionAmount, Leaderboard $leaderboard): void
    {
        if (null === $wallet->getDiscordUser()) {
            return;
        }

        $userScore = $this->userPointsRepository->findOneBy(['discordUserId' => $wallet->getDiscordUser()->getDiscordId()]);

        if (!$userScore instanceof UserScore) {
            $userScore = (new UserScore())
                ->setDiscordUserId($wallet->getDiscordUser()->getDiscordId())
                ->setLeaderboard($leaderboard)
            ;
        }

        $userScore->setScore(bcadd($userScore->getScore(), $transactionAmount));

        $this->entityManager->persist($userScore);
    }
}
