<?php

namespace App\CommandProcess\Admin\LeadTask;

use Rosamarsky\CommandBus\Command;

class UpdateLeadTask implements Command
{
    public int $taskId;
    public array $data;

    public function __construct(int $taskId, array $data)
    {
        $this->taskId = $taskId;
        $this->data = $data;
    }
}
