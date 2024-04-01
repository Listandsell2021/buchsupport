<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Services\Admin\InvoiceService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateInvoicesBulkActionHandler implements Handler
{

    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {
        $message = '';

        if ($command->action == 'delete') {
            $this->invoiceService->deleteBulk($command->invoiceIds);
            $message = trans('Invoices deleted successfully');
        }

        if ($command->action == 'paid') {
            $this->invoiceService->setBulkAsPaid($command->invoiceIds);
            $message = trans('Invoices marked as paid successfully');
        }

        if ($command->action == 'unpaid') {
            $this->invoiceService->setBulkAsUnpaid($command->invoiceIds);
            $message = trans('Invoices marked as unpaid successfully');
        }

        if ($command->action == 'payment_reminder') {
            $message = trans('Payment reminder created successfully');
        }

        if ($command->action == 'payment_warning') {
            $message = trans('Payment warning created successfully');
        }

        if ($command->action == 'cancel_invoice') {
            $message = trans('Invoices cancelled successfully');
        }

        return $message;
    }
}
