<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class CreateLeadProductCategory implements Command
{
    public int $leadId;
    public array $data;

    public function __construct(int $leadId, array $data)
    {
        $this->data = $data;
        $this->leadId = $leadId;
    }
}
