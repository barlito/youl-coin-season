<?php

namespace App\Entity;

use App\Enum\SeasonStatusEnum;
use App\Repository\SeasonRepository;
use Barlito\Utils\Traits\IdUuidTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    use IdUuidTrait;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $dateStart;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $dateEnd;

    #[Assert\NotBlank]
    #[Assert\Type(SeasonStatusEnum::class)]
    #[ORM\Column]
    private SeasonStatusEnum $status = SeasonStatusEnum::PENDING;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\OneToOne(mappedBy: 'season', cascade: ['persist', 'remove'])]
    private Leaderboard $leaderboard;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Reward::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $rewards;

    public function __construct()
    {
        $this->rewards = new ArrayCollection();
        $this->setLeaderboard(new Leaderboard());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateStart(): DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getStatus(): SeasonStatusEnum
    {
        return $this->status;
    }

    public function setStatus(SeasonStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLeaderboard(): Leaderboard
    {
        return $this->leaderboard;
    }

    public function setLeaderboard(Leaderboard $leaderboard): static
    {
        $leaderboard->setSeason($this);

        $this->leaderboard = $leaderboard;

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): static
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->setSeason($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): static
    {
        if ($this->rewards->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getSeason() === $this) {
                $reward->setSeason(null);
            }
        }

        return $this;
    }
}
