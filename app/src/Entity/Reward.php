<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\RankEnum;
use App\Enum\RewardStatusEnum;
use App\Enum\RewardTypeEnum;
use App\Repository\RewardRepository;
use Barlito\Utils\Traits\IdUuidTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RewardRepository::class)]
class Reward
{
    use IdUuidTrait;

    #[Assert\NotBlank]
    #[Assert\Type(RewardTypeEnum::class)]
    #[ORM\Column(length: 255)]
    private RewardTypeEnum $type;

    #[Assert\NotBlank]
    #[ORM\Column]
    private int $amount;

    #[Assert\NotBlank]
    #[Assert\Type(RewardStatusEnum::class)]
    #[ORM\Column]
    private RewardStatusEnum $status = RewardStatusEnum::UNCLAIMED;

    #[Assert\When(
        expression: 'this.getType().name !== "' . RewardTypeEnum::YOUL_COIN->name . '"',
        constraints: [
            new Assert\Uuid(),
            new Assert\NotBlank(),
        ],
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[Assert\NotBlank]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'rewards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Season $season;

    #[Assert\NotBlank]
    #[Assert\Type(RankEnum::class)]
    #[ORM\Column]
    private RankEnum $rank;

    public function getType(): RewardTypeEnum
    {
        return $this->type;
    }

    public function setType(RewardTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): RewardStatusEnum
    {
        return $this->status;
    }

    public function setStatus(RewardStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(?string $externalId): static
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getSeason(): Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getRank(): RankEnum
    {
        return $this->rank;
    }

    public function setRank(RankEnum $rank): Reward
    {
        $this->rank = $rank;

        return $this;
    }
}
