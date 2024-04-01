<?php

namespace App\CommandProcess\Admin\LeadTask;

use Rosamarsky\CommandBus\Command;

class StoreLeadTask implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
