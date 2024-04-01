<?php

namespace App\CommandProcess\Admin\LeadAppointment;

use Rosamarsky\CommandBus\Command;

class StoreLeadAppointment implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
