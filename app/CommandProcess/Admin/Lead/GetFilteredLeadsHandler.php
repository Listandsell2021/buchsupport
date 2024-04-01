<?php

namespace App\CommandProcess\Admin\Lead;



use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredLeadsHandler implements Handler
{

    private LeadService $dbService;

    public function __construct(LeadService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->data);
    }
}
