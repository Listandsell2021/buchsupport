<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class GetLeadAddedProducts implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
