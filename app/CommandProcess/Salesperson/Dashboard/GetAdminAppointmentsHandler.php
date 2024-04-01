<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use App\Models\LeadActivity;
use App\Models\LeadAppointment;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetAdminAppointmentsHandler implements Handler
{

    public function __construct()
    {

    }

    public function handle(Command $command)
    {
        $leadId = (int) request('lead_id');

        return LeadAppointment::select('*')
            ->where(function ($query) use ($leadId) {
                if ($leadId > 0) {
                    $query->where('lead_appointments.lead_id', $leadId);
                }
            })
            ->join('leads', 'lead_appointments.lead_id', 'leads.id')
            ->where('leads.salesperson_id', getAdminId())
            ->get();
    }
}
