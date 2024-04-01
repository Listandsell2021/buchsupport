<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class DownloadCustomerInvoiceHandler implements Handler
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

        if (!$invoice) {
            throw ValidationException::withMessages(['invoice_id' => trans('Invoice not found')]);
        }

        $filePath = Storage::path(getCustomerInvoiceStorageRelativePath($invoice->invoice_path));

        if (!File::exists($filePath)) {
            throw ValidationException::withMessages(['invoice_id' => trans('Invoice file not found')]);
        }

        return response()->download($filePath, $invoice->document_name);
    }
}

