<?php

declare(strict_types=1);

namespace App\Enum;

enum RewardTypeEnum: string
{
    case YOUL_COIN = 'youl_coin';

    case CARD = 'card';

    case BOOSTER_PACK = 'booster_pack';
}
