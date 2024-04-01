<?php

namespace App\CommandProcess\Admin\LeadStatus;

use Rosamarsky\CommandBus\Command;

class SetDefaultLeadStatus implements Command
{
    public int $leadStatusId;
    public int $default;

    public function __construct(int $leadStatusId, int $default)
    {
        $this->leadStatusId = $leadStatusId;
        $this->default = $default;
    }
}
