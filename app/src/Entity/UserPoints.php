<?php

namespace App\Entity;

use App\Repository\UserPointsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPointsRepository::class)]
class UserPoints
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $points = null;

    #[ORM\Column(length: 255)]
    private ?string $amountStart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $amountEnd = null;

    #[ORM\Column(length: 255)]
    private ?string $walletId = null;

    #[ORM\Column(length: 255)]
    private ?string $discordUserId = null;

    #[ORM\ManyToOne(inversedBy: 'UserPoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Leaderboard $leaderboard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getAmountStart(): ?string
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

    public function getWalletId(): ?string
    {
        return $this->walletId;
    }

    public function setWalletId(string $walletId): static
    {
        $this->walletId = $walletId;

        return $this;
    }

    public function getDiscordUserId(): ?string
    {
        return $this->discordUserId;
    }

    public function setDiscordUserId(string $discordUserId): static
    {
        $this->discordUserId = $discordUserId;

        return $this;
    }

    public function getLeaderboard(): ?Leaderboard
    {
        return $this->leaderboard;
    }

    public function setLeaderboard(?Leaderboard $leaderboard): static
    {
        $this->leaderboard = $leaderboard;

        return $this;
    }
}
