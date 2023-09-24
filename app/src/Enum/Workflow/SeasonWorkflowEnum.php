<?php

declare(strict_types=1);

namespace App\Enum\Workflow;

enum SeasonWorkflowEnum: string
{
    case ACTIVATE = 'activate';
    case FINISH = 'finish';
}
