<?php

namespace App\CommandProcess\Admin\SmartList;


use App\Services\Admin\SmartListService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetSmartListLeadsHandler implements Handler
{

    private SmartListService $dbService;

    public function __construct(SmartListService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getSmartListLeads($command->smartListId);
    }
}
