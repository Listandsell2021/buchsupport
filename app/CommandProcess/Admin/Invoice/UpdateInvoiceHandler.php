<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class UpdateInvoiceHandler implements Handler
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {
        $success = true;

        $setting = Setting::all();

        DB::beginTransaction();

        try {
            $this->invoiceService->updateInvoice($command->data['invoice_id'], $command->data);

            $invoice = $this->invoiceService->getById($command->data['invoice_id']);
            $invoiceName = $invoice->invoice_no.'.pdf';

            $pdf = Pdf::loadView('admin.invoice.customer_invoice', compact('invoice', 'setting'));

            $pdf->save(getCustomerInvoiceStorageAbsolutePath($invoiceName));

            DB::commit();
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }

        return $success;
    }

}
