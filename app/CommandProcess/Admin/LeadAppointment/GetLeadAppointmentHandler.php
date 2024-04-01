<?php

namespace App\CommandProcess\Admin\LeadAppointment;


use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\RoleResource;
use App\Services\Admin\LeadAppointmentService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetLeadAppointmentHandler implements Handler
{

    public LeadAppointmentService $dbService;

    public function __construct(LeadAppointmentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getById($command->appointmentId);
    }
}
