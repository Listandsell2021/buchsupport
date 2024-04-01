<?php

namespace App\CommandProcess\Admin\LeadStatus;

use Rosamarsky\CommandBus\Command;

class UpdateLeadStatus implements Command
{
    public int $leadStatusId;
    public array $data;

    public function __construct(int $leadStatusId, array $data)
    {
        $this->leadStatusId = $leadStatusId;
        $this->data = $data;
    }
}
