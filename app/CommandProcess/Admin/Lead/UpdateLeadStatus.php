<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateLeadStatus implements Command
{
    public int $leadId;
    public int $status_id;

    public function __construct(int $leadId, int $status_id)
    {
        $this->leadId = $leadId;
        $this->status_id = $status_id;
    }
}
