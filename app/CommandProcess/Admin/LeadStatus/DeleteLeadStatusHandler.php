<?php

namespace App\CommandProcess\Admin\LeadStatus;


use App\Services\Admin\LeadStatusService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteLeadStatusHandler implements Handler
{

    private LeadStatusService $dbService;

    /**
     * @param LeadStatusService $dbService
     */
    public function __construct(LeadStatusService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->leadStatusId);
    }
}
