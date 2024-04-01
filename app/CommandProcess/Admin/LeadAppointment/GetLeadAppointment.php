<?php

namespace App\CommandProcess\Admin\LeadAppointment;

use Rosamarsky\CommandBus\Command;

class GetLeadAppointment implements Command
{
    public int $appointmentId;

    public function __construct(int $appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }
}
