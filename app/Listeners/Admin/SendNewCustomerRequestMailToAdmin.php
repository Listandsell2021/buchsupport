<?php

namespace App\Listeners\Admin;

use Illuminate\Support\Facades\Mail;

class SendNewCustomerRequestMailToAdmin
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
        Mail::to(getAdminReceiverMail())->send(new \App\Mail\Admin\Lead\NewCustomerRequestMailToAdmin($event->lead));
    }

}
