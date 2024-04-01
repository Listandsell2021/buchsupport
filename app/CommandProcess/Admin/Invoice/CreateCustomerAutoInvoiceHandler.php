<?php

namespace App\CommandProcess\Admin\Invoice;

use App\Libraries\Settings\Setting;
use App\Models\User;
use App\Services\Admin\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class CreateCustomerAutoInvoiceHandler implements Handler
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

            $year = date('Y');
            $setting = Setting::all();
            $customer = $this->invoiceService->getCustomerDetail($command->customerId);

            $services = [
                [
                    'item_no' => 1001,
                    'service' => trans('Membership')." ".ucfirst($customer->membership)."\n".trans('Registration')
                        ."\n".trans('Identity').':'.getCustomerUidSpaced($customer->uid),
                    'quantity' => 1,
                    'unit_price' => $customer->product_price,
                    'total_price' => $customer->product_price
                ],
            ];

            $incrementalNo = $this->invoiceService->getIncrementalNo($year);

            $serviceTotal = (float) $customer->product_price;
            $vat = Setting::getVatPercentage();
            $vatTotal = ($serviceTotal * $vat) / 100;
            $subtotal = $serviceTotal - $vatTotal;
            $total = $serviceTotal;

            $invoiceNo = getInvoiceNo($year, $incrementalNo);
            $invoiceName = $invoiceNo.'.pdf';

            $invoice = $this->invoiceService->createInvoice([
                'user_id'           => $command->customerId,

                'year'              => $year,
                'invoice_date'      => date(getGlobalDateFormat()),
                'incremental_no'    => $incrementalNo,
                'invoice_no'        => $invoiceNo,

                'user_company'      => '',
                'user_gender'       => $customer->gender,
                'user_name'         => $customer->fullname(),
                'user_address'      => $customer->street."\n".$customer->postal_code.' '.$customer->city,
                'user_no'           => $customer->id,

                'services'          => $services,
                'service_total'     => $serviceTotal,
                'subtotal'          => $subtotal,
                'vat'               => $vat,
                'vat_total'         => $vatTotal,
                'total'             => $total,

                'invoice_path'      => $invoiceName,
                'is_paid'           => 0,
            ]);

            // return view('admin.invoice.customer_invoice', compact('invoice', 'setting'));

            $pdf = Pdf::loadView('admin.invoice.customer_invoice', compact( 'invoice', 'setting'));

            $pdf->save(getCustomerInvoiceStorageAbsolutePath($invoiceName));

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
        }

    }
}
