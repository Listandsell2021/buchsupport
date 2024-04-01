<?php

namespace App\CommandProcess\Salesperson\Dashboard;

use App\Models\LeadActivity;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetAdminLeadActivitiesHandler implements Handler
{

    public function __construct()
    {

    }

    public function handle(Command $command)
    {
        $leadId = (int) request('lead_id');
        return LeadActivity::select('*')
            ->where(function ($query) use ($leadId) {
                if ($leadId > 0) {
                    $query->where('lead_activities.lead_id', $leadId);
                }
            })
            ->join('leads', 'lead_activities.lead_id', 'leads.id')
            ->where('leads.salesperson_id', getAdminId())
            ->get();
    }
}
