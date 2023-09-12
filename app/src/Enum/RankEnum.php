<?php

declare(strict_types=1);

namespace App\Enum;

enum RankEnum: string
{
    case FIRST = 'first';

    case SECOND = 'second';

    case THIRD = 'third';

    case LAST = 'last';
}
