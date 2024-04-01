<?php

namespace App\CommandProcess\Admin\LeadDocument;

use Rosamarsky\CommandBus\Command;

class DownloadLeadDocument implements Command
{
    public int $documentId;

    public function __construct(int $documentId)
    {
        $this->documentId = $documentId;
    }
}
