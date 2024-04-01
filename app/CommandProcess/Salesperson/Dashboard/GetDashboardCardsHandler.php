<?php

namespace App\CommandProcess\Salesperson\Dashboard;


use App\Models\Lead;
use App\Models\LeadAppointment;
use App\Models\LeadNote;
use App\Models\LeadTask;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetDashboardCardsHandler implements Handler
{

    public function handle(Command $command)
    {
        $totalLeads = Lead::active()->where('leads.salesperson_id', getAdminId())->count();

        $totalAppointments = LeadAppointment::join('leads', 'lead_appointments.lead_id', 'leads.id')
            ->where('lead_appointments.admin_id', getAdminId())
            ->where('leads.salesperson_id', getAdminId())
            ->where('leads.is_converted', 0)
            ->count();

        $totalTasks = LeadTask::join('leads', 'lead_tasks.lead_id', 'leads.id')
            ->where('lead_tasks.admin_id', getAdminId())
            ->where('leads.salesperson_id', getAdminId())
            ->where('leads.is_converted', 0)
            ->count();

        return [
            'total_leads'           => $totalLeads,
            'total_appointments'    => $totalAppointments,
            'total_notes'           => $totalTasks,
        ];
    }

}
