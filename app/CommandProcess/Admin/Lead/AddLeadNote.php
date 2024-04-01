<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class AddLeadNote implements Command
{
    public int $leadId;
    public string $note;

    public function __construct(int $leadId, string $note)
    {
        $this->leadId = $leadId;
        $this->note = $note;
    }
}
