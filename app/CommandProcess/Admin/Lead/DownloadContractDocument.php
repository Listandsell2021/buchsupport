<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class DownloadContractDocument implements Command
{
    public int $contractId;

    public function __construct(int $contractId)
    {
        $this->contractId = $contractId;
    }
}
