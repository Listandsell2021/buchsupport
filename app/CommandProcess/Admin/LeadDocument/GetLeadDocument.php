<?php

namespace App\CommandProcess\Admin\LeadDocument;

use Rosamarsky\CommandBus\Command;

class GetLeadDocument implements Command
{
    public int $documentId;

    public function __construct(int $documentId)
    {
        $this->documentId = $documentId;
    }
}
