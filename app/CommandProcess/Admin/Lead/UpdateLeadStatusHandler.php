<?php

namespace App\CommandProcess\Admin\Lead;


use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateLeadStatusHandler implements Handler
{

    public LeadService $dbService;

    public function __construct(LeadService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->updateStatus($command->leadId, $command->status_id);
    }
}
