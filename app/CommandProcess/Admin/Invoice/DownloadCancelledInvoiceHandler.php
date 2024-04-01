<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadCancelledInvoiceHandler implements Handler
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @throws ValidationException
     */
    public function handle(Command $command)
    {
        $invoice = $this->invoiceService->getById($command->invoiceId);

        $filePath = getCustomerInvoiceStorageAbsolutePath($invoice->cancelled_invoice_path);

        if (!File::exists($filePath)) {
            throw ValidationException::withMessages(['cancelled_invoice' => trans('Cancelled invoice file not found')]);
        }

        return response()->download($filePath, 'storno_'.$invoice->invoice_no.'.pdf');
    }
}

