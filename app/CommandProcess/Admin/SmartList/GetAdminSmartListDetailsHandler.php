<?php

namespace App\CommandProcess\Admin\SmartList;


use App\Services\Admin\LeadService;
use App\Services\Admin\SmartListService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetAdminSmartListDetailsHandler implements Handler
{

    private SmartListService $dbService;
    private LeadService $leadService;

    public function __construct(SmartListService $dbService, LeadService $leadService)
    {
        $this->dbService = $dbService;
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $totalLeads = $this->leadService->getTotalLeads();
        $smartLists = $this->dbService->getAdminSmartListDetails();

        return [
            'total_leads' => $totalLeads,
            'smart_lists' => $smartLists
        ];
    }
}
