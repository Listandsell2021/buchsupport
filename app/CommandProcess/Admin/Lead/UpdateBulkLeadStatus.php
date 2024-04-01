<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateBulkLeadStatus implements Command
{
    public int $leadStatusId;

    public function __construct(int $leadStatusId)
    {
        $this->leadStatusId = $leadStatusId;
    }
}
