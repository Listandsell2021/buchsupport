<?php

namespace App\CommandProcess\Admin\LeadStatus;

use Rosamarsky\CommandBus\Command;

class DeleteLeadStatus implements Command
{
    public int $leadStatusId;

    public function __construct(int $leadStatusId)
    {
        $this->leadStatusId = $leadStatusId;
    }
}
