<?php

namespace App\CommandProcess\Admin\Lead;


use App\DataHolders\Enum\NotificationTypes;
use App\Events\Admin\LeadNewCustomerRequest;
use App\Models\Notification;
use App\Services\Admin\LeadService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class RequestForNewCustomerHandler implements Handler
{

    private LeadService $leadService;

    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    public function handle(Command $command)
    {
        $lead = $this->leadService->requestForNewCustomer($command->leadId);

        event(new LeadNewCustomerRequest($lead));
    }
}
