<?php

declare(strict_types=1);

namespace App\Validator\Entity\Season;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class SeasonStatus extends Constraint
{
    public const UNIQUE_ACTIVE_SEASON_ERROR = 'Only one Season can be Active at a time.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
