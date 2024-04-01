<?php

namespace App\CommandProcess\Admin\LeadAppointment;


use App\Http\Resources\Admin\AdminResource;
use App\Models\LeadAppointment;
use App\Services\Admin\LeadAppointmentService;
use Illuminate\Support\Arr;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class StoreLeadAppointmentHandler implements Handler
{

    private LeadAppointmentService $dbService;

    public function __construct(LeadAppointmentService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $command->data['admin_id'] = getAdminId();

        return $this->dbService->save(Arr::only($command->data, LeadAppointment::fillableProps()));
    }
}
