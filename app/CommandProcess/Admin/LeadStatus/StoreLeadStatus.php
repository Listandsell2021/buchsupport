<?php

namespace App\CommandProcess\Admin\LeadStatus;

use Rosamarsky\CommandBus\Command;

class StoreLeadStatus implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
