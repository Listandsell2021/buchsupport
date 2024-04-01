<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateInvoicePaymentReminderHandler implements Handler
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
            $reminderPath = getPaymentReminderFileName($invoice->invoice_no);
            $reminderDate = date('Y-m-d');

            $pdf = Pdf::loadView('admin.invoice.payment_reminder', compact( 'invoice', 'setting'));
            createFolderIFNotExist(getPaymentReminderStorageAbsolutePath());
            $pdf->save(getPaymentReminderStorageAbsolutePath($reminderPath));

            $this->invoiceService->createPaymentReminder((int) $invoice->id, $reminderPath, $reminderDate);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }


//        $this->invoiceService->createPaymentReminder($path, $date);
    }
}
