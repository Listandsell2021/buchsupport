<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateLead implements Command
{
    public int $leadId;
    public array $data;

    public function __construct(int $leadId, array $data)
    {
        $this->leadId = $leadId;
        $this->data = $data;
    }
}
