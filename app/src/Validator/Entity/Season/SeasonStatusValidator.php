<?php

declare(strict_types=1);

namespace App\Validator\Entity\Season;

use App\Entity\Season;
use App\Enum\SeasonStatusEnum;
use App\Repository\SeasonRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SeasonStatusValidator extends ConstraintValidator
{
    public function __construct(private readonly SeasonRepository $seasonRepository)
    {
    }

    /**
     * @throws UnexpectedTypeException
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof SeasonStatus) {
            throw new UnexpectedTypeException($constraint, SeasonStatus::class);
        }

        if (!$value instanceof Season) {
            throw new UnexpectedTypeException($value, Season::class);
        }

        if (SeasonStatusEnum::ACTIVE !== $value->getStatus()) {
            return;
        }

        $activeSeason = $this->seasonRepository->findOneBy(['status' => SeasonStatusEnum::ACTIVE]);

        if (
            !$activeSeason instanceof Season
            || $activeSeason->getId() === $value->getId()
        ) {
            return;
        }

        $this->context->buildViolation($constraint::UNIQUE_ACTIVE_SEASON_ERROR)
            ->addViolation()
        ;
    }
}
