<?php

namespace App\CommandProcess\Admin\LeadAppointment;


use App\Services\Admin\LeadAppointmentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetFilteredLeadAppointmentsHandler implements Handler
{

    private LeadAppointmentService $dbService;

    public function __construct(LeadAppointmentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->searchAndPaginate($command->leadId);
    }
}
