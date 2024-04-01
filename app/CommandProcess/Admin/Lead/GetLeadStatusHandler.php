<?php

namespace App\CommandProcess\Admin\Lead;

use App\Models\LeadStatus;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadStatusHandler implements Handler
{

    public function handle(Command $command)
    {
        return LeadStatus::all();
    }
}
