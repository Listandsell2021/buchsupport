<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use Rosamarsky\CommandBus\Command;

class GetLeadDetail implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
