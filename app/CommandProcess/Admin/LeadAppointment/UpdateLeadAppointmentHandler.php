<?php

namespace App\CommandProcess\Admin\LeadAppointment;


use App\Services\Admin\LeadAppointmentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateLeadAppointmentHandler implements Handler
{

    public LeadAppointmentService $dbService;

    public function __construct(LeadAppointmentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $data = [
            'description'   => $command->data['description'],
            'start_at'      => $command->data['start_at'],
        ];

        $this->dbService->update($command->appointmentId, $data);
    }
}
