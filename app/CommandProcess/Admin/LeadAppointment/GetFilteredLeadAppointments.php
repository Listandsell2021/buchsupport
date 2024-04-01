<?php

namespace App\CommandProcess\Admin\LeadAppointment;

use Rosamarsky\CommandBus\Command;

class GetFilteredLeadAppointments implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
