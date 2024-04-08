<?php

namespace App\CommandProcess\Admin\Lead;


use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateLeadHandler implements Handler
{

    public LeadService $dbService;

    public function __construct(LeadService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        if (isAuthSalesperson()) {
            unset($command->data['salesperson_id']);
        }

        $this->dbService->update($command->leadId, $command->data);
    }
}
