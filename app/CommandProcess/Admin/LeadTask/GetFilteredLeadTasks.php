<?php

namespace App\CommandProcess\Admin\LeadTask;

use Rosamarsky\CommandBus\Command;

class GetFilteredLeadTasks implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
