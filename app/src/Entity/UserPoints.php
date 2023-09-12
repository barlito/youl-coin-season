<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserPointsRepository;
use Barlito\Utils\Traits\IdUuidTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserPointsRepository::class)]
class UserPoints
{
    use IdUuidTrait;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $score;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $amountStart;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $amountEnd = null;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Column(length: 255)]
    private string $walletId;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $discordUserId;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'UserPoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leaderboard $leaderboard;

    public function getScore(): string
    {
        return $this->score;
    }

    public function setScore(string $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getAmountStart(): string
    {
        return $this->amountStart;
    }

    public function setAmountStart(string $amountStart): static
    {
        $this->amountStart = $amountStart;

        return $this;
    }

    public function getAmountEnd(): ?string
    {
        return $this->amountEnd;
    }

    public function setAmountEnd(?string $amountEnd): static
    {
        $this->amountEnd = $amountEnd;

        return $this;
    }

    public function getWalletId(): string
    {
        return $this->walletId;
    }

    public function setWalletId(string $walletId): static
    {
        $this->walletId = $walletId;

        return $this;
    }

    public function getDiscordUserId(): string
    {
        return $this->discordUserId;
    }

    public function setDiscordUserId(string $discordUserId): static
    {
        $this->discordUserId = $discordUserId;

        return $this;
    }

    public function getLeaderboard(): Leaderboard
    {
        return $this->leaderboard;
    }

    public function setLeaderboard(?Leaderboard $leaderboard): static
    {
        $this->leaderboard = $leaderboard;

        return $this;
    }
}
