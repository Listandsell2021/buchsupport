<?php

namespace App\CommandProcess\Admin\Lead;


use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateContractProductsHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $this->leadService->updateContractProducts($command->contractId, $command->products);
    }
}
