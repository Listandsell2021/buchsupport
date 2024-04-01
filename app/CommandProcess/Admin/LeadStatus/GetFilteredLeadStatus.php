<?php

namespace App\CommandProcess\Admin\LeadStatus;

use Rosamarsky\CommandBus\Command;

class GetFilteredLeadStatus implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
