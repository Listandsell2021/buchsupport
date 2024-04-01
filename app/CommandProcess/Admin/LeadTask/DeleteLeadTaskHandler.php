<?php

namespace App\CommandProcess\Admin\LeadTask;


use App\Services\Admin\LeadTaskService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteLeadTaskHandler implements Handler
{

    private LeadTaskService $dbService;

    /**
     * @param LeadTaskService $dbService
     */
    public function __construct(LeadTaskService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->taskId);
    }
}
