<?php

namespace App\CommandProcess\Admin\Invoice;

use App\DataHolders\Enum\Gender;
use App\Libraries\Settings\Setting;
use App\Services\Admin\InvoiceService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetInvoiceDataHandler implements Handler
{

    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(Command $command)
    {
        $year = date('Y');
        $setting = Setting::all();

        $customer = null;

        if ((int) $command->customerId > 0) {
            $customer = $this->invoiceService->getCustomerDetail($command->customerId);
        }

        $incrementalNo = $this->invoiceService->getIncrementalNo($year);

        $serviceTotal = roundNumber($customer ? $customer->product_price : 0);
        $vat = Setting::getVatPercentage();
        $vatTotal = roundNumber(($serviceTotal * $vat) / 100);
        $subtotal = $serviceTotal - $vatTotal;
        $total = $serviceTotal;

        $invoiceNo = getInvoiceNo($year, $incrementalNo);

/*        <p>Sehr geehrter {customer},
                            <br> vielen Dank für Ihren Auftrag!
                            <br> Wir bestätigen Ihnen den Kaufvertrag vom {invoice_date}
                            <br> Der Kaufpreis beträgt <span>{invoice_price}</span>
                            <br> Bitte zahlen Sie die Rechnungssumme nach Rechnungserhalt auf das unten angegebene Konto. </p>*/

        $userGender = $customer ? $customer->gender : Gender::male->name;
        $userName = ($customer ? $customer->fullname() : '');
        $invoiceDate = getDateByLocale();

        $invoiceHeading = getSettingTemplate($setting['invoice_heading'], ['invoice_no' => $invoiceNo]);
        $invoiceDescription = getSettingTemplate($setting['invoice_description'], [
            'customer' => getGenderValue($userGender).' '.$userName,
            'invoice_date' => $invoiceDate,
            'invoice_price' => getCurrencyPrice($total),
        ]);

        return [

            'user_gender' => $userGender,
            'user_name' => $userName,
            'user_address' => ($customer ? $customer->street."\n".$customer->postal_code.' '.$customer->city : ''),

            'invoice_date' => $invoiceDate,
            'user_no' => ($customer ? $customer->id : ''),
            'user_id' => ($customer ? $customer->id : ''),
            'invoice_no' => $invoiceNo,

            'services' => [
                [
                    'item_no' => 1001,
                    'service' => trans('Membership').' '.($customer ? ucfirst($customer->membership) : '')
                        ."\n".trans('Registration')
                        ."\n".trans('Identity').':'.($customer ? getCustomerUidSpaced($customer->uid) : ''),
                    'quantity' => 1,
                    'unit_price' => ($customer ? $serviceTotal : 0),
                    'total_price' => ($customer ? $serviceTotal : 0)
                ]
            ],
            'service_total'   => $serviceTotal,
            'subtotal'        => $subtotal,
            'vat'             => $vat,
            'vat_total'       => $vatTotal,
            'total'           => $total,

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
