<?php

namespace App\CommandProcess\Admin\Lead;

use App\Helpers\EloquentFilters\Admin\LeadFilter;
use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateBulkLeadSalespersonHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $leadIds = LeadFilter::getLeadIdsBySearchFilters();

        $this->leadService->updateBulkSalesperson($leadIds, $command->salespersonId);
    }
}
