<?php

namespace App\CommandProcess\Admin\Invoice;


use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\File;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DeleteInvoiceHandler implements Handler
{

    private InvoiceService $dbService;

    /**
     * @param InvoiceService $dbService
     */
    public function __construct(InvoiceService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        $invoice = $this->dbService->getById($command->invoiceId);

        if (File::exists(getCustomerInvoiceStorageAbsolutePath($invoice->invoice_path))) {
            File::delete(getCustomerInvoiceStorageAbsolutePath($invoice->invoice_path));
        }

        if (File::exists(getCustomerInvoiceStorageAbsolutePath($invoice->cancelled_invoice_path))) {
            File::delete(getCustomerInvoiceStorageAbsolutePath($invoice->cancelled_invoice_path));
        }

        if (File::exists(getPaymentReminderStorageAbsolutePath($invoice->payment_reminder_path))) {
            File::delete(getPaymentReminderStorageAbsolutePath($invoice->payment_reminder_path));
        }

        if (File::exists(getPaymentReminderStorageAbsolutePath($invoice->payment_warning_path))) {
            File::delete(getPaymentReminderStorageAbsolutePath($invoice->payment_warning_path));
        }

        $this->dbService->delete($command->invoiceId);
    }
}
