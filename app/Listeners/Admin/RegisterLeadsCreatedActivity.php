<?php

namespace App\Listeners\Admin;

use App\DataHolders\Enum\LeadActivityType;
use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterLeadsCreatedActivity
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
        $leads = Lead::whereIn('id', $event->leadIds)->get();

        $leadActivities = [];

        foreach ($leads as $lead) {
            $leadActivities[] = [
                'lead_id' => $lead->id,
                'admin_id' => getAdminId(),
                'description' => trans('New lead created'),
                'type' => LeadActivityType::lead_created->name,
                'created_at' => getCurrentDateTime(),
                'updated_at' => getCurrentDateTime(),
            ];
        }

        if (count($leadActivities) > 0) {
            foreach (array_chunk($leadActivities, 50) as $chunkedLeadActivities) {
                LeadActivity::insert($chunkedLeadActivities);
            }
        }
    }
}
