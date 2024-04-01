<?php

namespace App\CommandProcess\Admin\LeadAppointment;

use Rosamarsky\CommandBus\Command;

class UpdateLeadAppointment implements Command
{
    public int $appointmentId;
    public array $data;

    public function __construct(int $appointmentId, array $data)
    {
        $this->appointmentId = $appointmentId;
        $this->data = $data;
    }
}
