<?php

namespace App\CommandProcess\Admin\Lead;

use Rosamarsky\CommandBus\Command;

class UpdateBulkLeadSalesperson implements Command
{
    public int $salespersonId;

    public function __construct(int $salespersonId)
    {
        $this->salespersonId = $salespersonId;
    }
}
