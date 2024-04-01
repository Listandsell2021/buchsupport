<?php

namespace App\CommandProcess\Admin\LeadDocument;

use Rosamarsky\CommandBus\Command;

class GetFilteredLeadDocuments implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
