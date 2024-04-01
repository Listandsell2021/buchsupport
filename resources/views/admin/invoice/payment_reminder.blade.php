@extends('admin.invoice.__invoice_layout')

@section('content')

    <div class="invoice-box-header m-b-45 clearfix">

        <div class="invoice-top-header m-b-30 text-right">
            <img src="{{ getAbsoluteInvoiceLogoPath() }}" alt="logo"/>
        </div>

        <table class="table table-borderless">
            <tr>
                <td class="width-50-percent">
                    <div class="text-xs m-b-15">
                        {{ $setting['company_name'].' - '.$setting['company_street_address'].' - '.$setting['company_postal_code'].' '.$setting['company_city'] }}
                    </div>
                    <strong>
                        {{ $invoice->user_gender == \App\DataHolders\Enum\Gender::male->name ? 'Herrn' : 'Frau' }}
                        <br>
                        {{ $invoice->user_name }}
                        <br>
                        {!! $invoice->user_address !!}
                    </strong>
                </td>
                <td>
                    <div class="clearfix">
                        <div class="date-information">
                            <div><strong><u>{{ trans('How to reach us') }}</u></strong></div>
                            <table class="table table-borderless table-paddingless">
                                <tr>
                                    <td class="text-left">{{ trans('Internet') }}</td>
                                    <td class="text-left">{!! $setting['company_website'] !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">{{ trans('E-mail') }}</td>
                                    <td class="text-left">{!! $setting['company_email'] !!}</td>
                                </tr>
                                <tr>
                                    <td class="text-left">{{ trans('Telephone') }}</td>
                                    <td class="text-left">{!! $setting['company_phone_no'] !!}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">{{ trans('Vat No') }}</td>
                                    <td class="text-left">
                                        <strong>{{ trans('Vat No').' '.$setting['vat_id'] }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">{{ trans('Date') }}</td>
                                    <td class="text-left">
                                        <strong>{{ getDateInGermany($invoice->invoice_date) }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-left">{{ trans('Customer') }}</td>
                                    <td class="text-left"><strong>{{ $invoice->user_no }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-box-content m-b-75">

        <div class="payment-reminder-desc">
            {!! getSettingTemplate($setting['payment_reminder_text'], [
                'invoice_no' => $invoice->invoice_no,
                'customer' => getCustomerWithGender($invoice->user_gender, $invoice->user_name),
                'invoice_date' => getDateInGermany($invoice->invoice_date),
                'invoice_price' => getCurrencyPrice($invoice->total),
                'company_name' => getCompanyName()
            ]) !!}
        </div>

    </div>


    <div class="m-t-30 invoice-footer footer-bottom">
        <div class="invoice-footer-inner-container">
            <table style="border-collapse: collapse; width: 100%; border-width: 0px;">
                <tbody>
                    <tr>
                        <td style="border-width: 0px;">
                            <p>{{ trans('Receiver') }}<br>{{ trans('Bank Detail') }}</p>
                        </td>
                        <td style="border-width: 0px;">
                            Consulting GmbH<br>{!! $setting['bank_name'] !!}<br>
                            BIC {!! $setting['bank_bic_no'] !!},
                            IBAN {!! $setting['bank_iban_no'] !!}</td>
                    </tr>
                    <tr>
                        <td style="border-width: 0px;">
                            <strong>{{ trans('Managing Director') }}</strong><br>
                            {!! $setting['company_manager'] !!}
                        </td>
                        <td style="border-width: 0px;">
                            <strong>{{ trans("Registration court/no") }}</strong><br>
                            {!! $setting['company_registration_no'] !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection