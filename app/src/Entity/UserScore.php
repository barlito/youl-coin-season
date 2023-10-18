<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserPointsRepository;
use Barlito\Utils\Traits\IdUuidTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserPointsRepository::class)]
class UserScore
{
    use IdUuidTrait;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $score = '0';

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $discordUserId;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'UserScores')]
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
