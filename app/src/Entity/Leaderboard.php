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
    #[ORM\OneToMany(mappedBy: 'leaderboard', targetEntity: UserPoints::class, orphanRemoval: true)]
    private Collection $userPoints;

    #[ORM\OneToOne(inversedBy: 'leaderboard')]
    #[ORM\JoinColumn(nullable: false)]
    private Season $season;

    public function __construct()
    {
        $this->userPoints = new ArrayCollection();
    }

    /**
     * @return Collection<int, UserPoints>
     */
    public function getUserPoints(): Collection
    {
        return $this->userPoints;
    }

    public function addUserPoint(UserPoints $userPoint): static
    {
        if (!$this->userPoints->contains($userPoint)) {
            $this->userPoints->add($userPoint);
            $userPoint->setLeaderboard($this);
        }

        return $this;
    }

    public function removeUserPoint(UserPoints $userPoint): static
    {
        if ($this->userPoints->removeElement($userPoint)) {
            // set the owning side to null (unless already changed)
            if ($userPoint->getLeaderboard() === $this) {
                $userPoint->setLeaderboard(null);
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
