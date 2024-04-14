<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class DownloadContractDocument implements Command
{
    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }
}
