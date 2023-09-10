<?php

namespace App\Entity;

use App\Repository\LeaderboardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaderboardRepository::class)]
class Leaderboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'leaderboard', targetEntity: UserPoints::class)]
    private Collection $UserPoints;

    #[ORM\OneToOne(inversedBy: 'leaderboard', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Season $season = null;

    public function __construct()
    {
        $this->UserPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, UserPoints>
     */
    public function getUserPoints(): Collection
    {
        return $this->UserPoints;
    }

    public function addUserPoint(UserPoints $userPoint): static
    {
        if (!$this->UserPoints->contains($userPoint)) {
            $this->UserPoints->add($userPoint);
            $userPoint->setLeaderboard($this);
        }

        return $this;
    }

    public function removeUserPoint(UserPoints $userPoint): static
    {
        if ($this->UserPoints->removeElement($userPoint)) {
            // set the owning side to null (unless already changed)
            if ($userPoint->getLeaderboard() === $this) {
                $userPoint->setLeaderboard(null);
            }
        }

        return $this;
    }

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(Season $season): static
    {
        $this->season = $season;

        return $this;
    }
}
