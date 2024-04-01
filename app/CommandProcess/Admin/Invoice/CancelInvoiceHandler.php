<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CancelInvoiceHandler implements Handler
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {

        DB::beginTransaction();

        try {

            $setting = Setting::all();
            $invoice = $this->invoiceService->getById($command->invoiceId);
            $incrementalNo = $this->invoiceService->getCancelledIncrementalNo();
            $cancelledInvoiceNo = getCancelledInvoiceNo((string) $incrementalNo, $invoice->invoice_no);
            $cancelledInvoiceName = 'storno_'.$cancelledInvoiceNo.'.pdf';

            $pdf = Pdf::loadView('admin.invoice.cancelled_invoice', compact( 'invoice', 'setting'));
            $pdf->save(getCustomerInvoiceStorageAbsolutePath($cancelledInvoiceName));
            $this->invoiceService->cancelInvoice((int) $invoice->id, $incrementalNo, $cancelledInvoiceNo, $cancelledInvoiceName);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }


//        $this->invoiceService->createPaymentReminder($path, $date);
    }
}
