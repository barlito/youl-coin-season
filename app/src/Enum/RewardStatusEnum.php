<?php

declare(strict_types=1);

namespace App\Enum;

enum RewardStatusEnum: string
{
    case UNCLAIMED = 'unclaimed';
    case CLAIMED = 'claimed';
}
