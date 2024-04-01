<?php

namespace App\CommandProcess\Admin\LeadTask;


use App\Services\Admin\LeadTaskService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateLeadTaskHandler implements Handler
{

    public LeadTaskService $dbService;

    public function __construct(LeadTaskService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $data = [
            'description'   => $command->data['description'],
            'due_at'        => $command->data['due_at'],
        ];

        $this->dbService->update($command->taskId, $data);
    }
}
