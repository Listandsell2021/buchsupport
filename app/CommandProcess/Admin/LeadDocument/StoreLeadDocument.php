<?php

namespace App\CommandProcess\Admin\LeadDocument;

use Rosamarsky\CommandBus\Command;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StoreLeadDocument implements Command
{
    public int $leadId;
    public mixed $document;

    public function __construct(int $leadId, mixed $document)
    {
        $this->leadId = $leadId;
        $this->document = $document;
    }
}
