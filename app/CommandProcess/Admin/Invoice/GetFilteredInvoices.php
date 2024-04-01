<?php

namespace App\CommandProcess\Admin\Invoice;

use Rosamarsky\CommandBus\Command;

class GetFilteredInvoices implements Command
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
