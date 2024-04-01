<?php

namespace App\Listeners\Admin;

use App\DataHolders\Enum\LeadActivityType;
use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class RegisterLeadNoteAddedActivity
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
            'lead_id'           => $event->leadId,
            'admin_id'          => getAdminId(),
            'description'       => Str::limit($event->note, 200, '...'),
            'type'              => LeadActivityType::lead_note_created->name,
            'data'              => ['lead_note_id' => $event->noteId]
        ]);
    }
}
