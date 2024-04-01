<?php

namespace App\CommandProcess\Admin\LeadStatus;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\LeadStatusService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadStatusHandler implements Handler
{

    public LeadStatusService $dbService;

    public function __construct(LeadStatusService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->leadStatusId);
    }
}
