<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\LeaderboardRepository;
use Barlito\Utils\Traits\IdUuidTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LeaderboardRepository::class)]
class Leaderboard
{
    use IdUuidTrait;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'leaderboard', targetEntity: UserScore::class, orphanRemoval: true)]
    private Collection $userScores;

    #[ORM\OneToOne(inversedBy: 'leaderboard')]
    #[ORM\JoinColumn(nullable: false)]
    private Season $season;

    public function __construct()
    {
        $this->userScores = new ArrayCollection();
    }

    /**
     * @return Collection<int, UserScore>
     */
    public function getUserScores(): Collection
    {
        return $this->userScores;
    }

    public function addUserScore(UserScore $userScore): static
    {
        if (!$this->userScores->contains($userScore)) {
            $this->userScores->add($userScore);
            $userScore->setLeaderboard($this);
        }

        return $this;
    }

    public function removeUserScore(UserScore $userScore): static
    {
        if ($this->userScores->removeElement($userScore)) {
            // set the owning side to null (unless already changed)
            if ($userScore->getLeaderboard() === $this) {
                $userScore->setLeaderboard(null);
            }
        }

        return $this;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }

    public function setSeason(Season $season): static
    {
        $this->season = $season;

        return $this;
    }
}
