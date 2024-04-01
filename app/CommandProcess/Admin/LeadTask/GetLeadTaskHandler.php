<?php

namespace App\CommandProcess\Admin\LeadTask;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\LeadTaskService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadTaskHandler implements Handler
{

    public LeadTaskService $dbService;

    public function __construct(LeadTaskService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->taskId);
    }
}
