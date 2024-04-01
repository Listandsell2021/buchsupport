<?php

namespace App\Listeners\Admin;

use App\DataHolders\Enum\LeadActivityType;
use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterLeadStatusUpdatedActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        LeadActivity::create([
            'lead_id'       => $event->leadId,
            'admin_id'      => getAdminId(),
            'description'   => $event->leadStatus,
            'type'          => LeadActivityType::lead_status_changed->name,
        ]);
    }
}
