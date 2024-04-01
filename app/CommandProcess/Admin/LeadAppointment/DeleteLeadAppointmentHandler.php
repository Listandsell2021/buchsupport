<?php

namespace App\CommandProcess\Admin\LeadAppointment;


use App\Services\Admin\LeadAppointmentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteLeadAppointmentHandler implements Handler
{

    private LeadAppointmentService $dbService;

    /**
     * @param LeadAppointmentService $dbService
     */
    public function __construct(LeadAppointmentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $this->dbService->delete($command->appointmentId);
    }
}
