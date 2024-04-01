<?php

namespace App\CommandProcess\Admin\Lead;

use Illuminate\Http\UploadedFile;
use Rosamarsky\CommandBus\Command;

class UploadContractDocument implements Command
{
    public int $leadId;
    public UploadedFile $document;

    public function __construct(int $leadId, UploadedFile $document)
    {
        $this->leadId = $leadId;
        $this->document = $document;
    }
}
