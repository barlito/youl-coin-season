<?php

declare(strict_types=1);

namespace App\Enum;

enum SeasonStatusEnum: string
{
    case PENDING = 'pending';

    case ACTIVE = 'active';

    case FINISHED = 'finished';
}
