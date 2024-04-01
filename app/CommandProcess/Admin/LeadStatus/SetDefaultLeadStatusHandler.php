<?php

namespace App\CommandProcess\Admin\LeadStatus;


use App\Services\Admin\LeadStatusService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SetDefaultLeadStatusHandler implements Handler
{

    public LeadStatusService $dbService;

    public function __construct(LeadStatusService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->setDefault($command->leadStatusId, $command->default);
    }
}
