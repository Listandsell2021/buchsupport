<?php

namespace App\CommandProcess\Admin\LeadAppointment;

use Rosamarsky\CommandBus\Command;

class DeleteLeadAppointment implements Command
{
    public int $appointmentId;

    public function __construct(int $appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }
}
