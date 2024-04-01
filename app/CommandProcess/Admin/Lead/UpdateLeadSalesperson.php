<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateLeadSalesperson implements Command
{
    public int $leadId;
    public int $salespersonId;

    public function __construct(int $leadId, int $salespersonId)
    {
        $this->leadId = $leadId;
        $this->salespersonId = $salespersonId;
    }
}
