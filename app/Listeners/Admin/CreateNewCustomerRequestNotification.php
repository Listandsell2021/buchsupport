<?php

namespace App\Listeners\Admin;

use App\DataHolders\Enum\NotificationTypes;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateNewCustomerRequestNotification
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
        Notification::create([
            'description' => "Lead to new customer request for <strong>".$event->lead->fullname()."</strong>",
            'type' => NotificationTypes::lead_new_customer->name,
            'data' => ['lead_id' => $event->lead->id],
            'has_read' => 0,
        ]);
    }
}
