<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;


class CreatePaymentWarningHandler implements Handler
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
            $fileName = getPaymentWarningFileName($invoice->invoice_no);
            $date = date('Y-m-d');

            /*$check = 1;
            return view('admin.invoice.payment_warning', compact('invoice', 'setting', 'check'));*/

            $pdf = Pdf::loadView('admin.invoice.payment_warning', compact( 'invoice', 'setting'));

            createFolderIFNotExist(getPaymentReminderStorageAbsolutePath());

            $pdf->save(getPaymentReminderStorageAbsolutePath($fileName));

            $this->invoiceService->createPaymentWarning((int) $invoice->id, $fileName, $date);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

    }
}
