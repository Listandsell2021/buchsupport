<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateLeadObjection implements Command
{
    public int $leadId;
    public string $reason;

    public function __construct(int $leadId, string $reason)
    {
        $this->leadId = $leadId;
        $this->reason = $reason;
    }
}
