<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Models\User;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateCustomerCustomInvoiceHandler implements Handler
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
        $data = $command->data;
        $invoiceDate = new \DateTime($data['invoice_date']);
        $incrementalNo = $this->invoiceService->getIncrementalNo($invoiceDate->format('Y'));
        $invoiceName = $data['invoice_no'].'.pdf';

        DB::beginTransaction();

        try {
            $invoice = $this->invoiceService->createInvoice([
                'user_id'           => hasInput($command->data['user_id']) ? $command->data['user_id'] : null,

                'year'              => $invoiceDate->format('Y'),
                'invoice_date'      => $invoiceDate->format('Y-m-d'),
                'incremental_no'    => $incrementalNo,
                'invoice_no'        => $data['invoice_no'],

                'user_company'      => null,
                'user_gender'       => $data['user_gender'],
                'user_name'         => $data['user_name'],
                'user_address'      => $data['user_address'],
                'user_no'           => $data['user_no'],

                'services'          => $data['services'],
                'service_total'     => roundNumber($data['service_total']),
                'subtotal'          => roundNumber($data['subtotal']),
                'vat'               => $data['vat'],
                'vat_total'         => roundNumber($data['vat_total']),
                'total'             => roundNumber($data['total']),

                'invoice_path'      => $invoiceName,

            ]);

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
