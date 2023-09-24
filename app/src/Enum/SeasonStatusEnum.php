<?php

declare(strict_types=1);

namespace App\Enum;

enum SeasonStatusEnum: string
{
    case CREATED = 'created';

    case ACTIVE = 'active';

    case FINISHED = 'finished';
}
