<?php

namespace App\CommandProcess\Admin\LeadTask;

use Rosamarsky\CommandBus\Command;

class DeleteLeadTask implements Command
{
    public int $taskId;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }
}
