<?php

namespace App\CommandProcess\Admin\Invoice;

use App\DataHolders\Enum\Gender;
use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetInvoiceHandler implements Handler
{

    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {
        $invoice = $this->invoiceService->getById($command->invoiceId);
        $setting = Setting::all();

        return [
            'invoice_id'    => $invoice->id,
            'user_gender'   => $invoice->user_gender,
            'user_name'     => $invoice->user_name,
            'user_address'  => $invoice->user_address,

            'invoice_date'  => getDateByLocale($invoice->invoice_date),
            'user_no'       => $invoice->user_no,
            'user_id'       => $invoice->user_id,
            'invoice_no'    => $invoice->invoice_no,

            'services'      => $invoice->services,
            'service_total' => $invoice->service_total,
            'subtotal'      => $invoice->subtotal,
            'vat'           => $invoice->vat,
            'vat_total'     => $invoice->vat_total,
            'total'         => $invoice->total,

            '__invoice_heading' => $setting['invoice_heading'],
            '__invoice_description' => $setting['invoice_description'],
            '__company_address' => $setting['company_name'].' - '.$setting['company_street_address'].' - '.$setting['company_postal_code'].' '.$setting['company_city'],
            '__company_website' => $setting['company_website'],
            '__company_email' => $setting['company_email'],
            '__company_phone_no' => $setting['company_phone_no'],
            '__company_vat_id' => $setting['vat_id'],
            '__bank_name'       => $setting['bank_name'],
            '__bank_bic_no'     => $setting['bank_bic_no'],
            '__bank_iban_no'    => $setting['bank_iban_no'],
            '__company_manager' => $setting['company_manager'],
            '__company_registration_no' => $setting['company_registration_no'],
        ];

    }
}
