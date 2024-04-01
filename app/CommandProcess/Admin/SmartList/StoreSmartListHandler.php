<?php

namespace App\CommandProcess\Admin\SmartList;


use App\Helpers\EloquentFilters\Admin\LeadFilter;
use App\Services\Admin\LeadService;
use App\Services\Admin\SmartListService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreSmartListHandler implements Handler
{
    private SmartListService $dbService;

    public function __construct(SmartListService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $leadIds = LeadFilter::getLeadIdsBySearchFilters();

        return $this->dbService->save($leadIds, $command->name, $command->salespersonId);
    }
}
