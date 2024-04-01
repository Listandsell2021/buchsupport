<?php

namespace App\CommandProcess\Admin\LeadTask;


use App\Services\Admin\LeadTaskService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredLeadTasksHandler implements Handler
{

    private LeadTaskService $dbService;

    public function __construct(LeadTaskService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->leadId);
    }
}
