<?php

namespace App\CommandProcess\Admin\Invoice;

use Rosamarsky\CommandBus\Command;

class DownloadCustomerInvoice implements Command
{
    public int $invoiceId;

    public function __construct(int $invoiceId)
    {

        $this->invoiceId = $invoiceId;
    }

}

