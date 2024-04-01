<?php

namespace App\CommandProcess\Admin\Lead;


use App\DataHolders\Enum\Membership;
use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateContractMembershipHandler implements Handler
{
    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $this->leadService->updateContractMembership($command->leadId, $command->membership);
    }
}
