<?php

namespace App\CommandProcess\Admin\Invoice;

use Rosamarsky\CommandBus\Command;

class UpdateInvoicesBulkAction implements Command
{
    public array $invoiceIds;
    public string $action;

    public function __construct(array $invoiceIds, string $action)
    {
        $this->invoiceIds = $invoiceIds;
        $this->action = $action;
    }
}
