<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Services\Admin\InvoiceService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class SetInvoiceUnpaidHandler implements Handler
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {
        $this->invoiceService->setAsUnpaid($command->invoiceId);
    }
}
