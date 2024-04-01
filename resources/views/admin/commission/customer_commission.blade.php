@extends('admin.commission.__commission_layout')

@section('content')

    <div class="invoice-box-header m-b-45 clearfix">
        <table>
            <tr>
                <td class="width-50-percent">
                    <div class="common-box">
                        <h4 class="top-title">@lang('Commission accounting')</h4>
                    </div>
                    <div class="common-box">
                        <strong>@lang('Date')</strong> {{ getDateInGermany($commission->commission_date) }} <br/>
                        <strong>@lang('Billing No')</strong> {{ $commission->id }} <br/>
                        <strong>@lang('Period')</strong> {{ getDateInGermany($commission->commission_from) }} - {{ getDateInGermany($commission->commission_to) }}<br/>
                        <strong>@lang('Tax No')</strong> {{ $setting['vat_id'] }}
                    </div>
                    <div class="common-box">
                        <strong>@lang('Date')</strong> <br/>
                        <span>{{ $admin->first_name }} {{ $admin->last_name }}</span> <br/>
                        <span>{{ $admin->street }}</span> <br/>
                        <span>{{ $admin->postal_code.' '.$admin->city }}</span> <br/>
                    </div>
                    <div class="common-box">
                        <strong>@lang('Exhibitor')</strong> <br/>
                        <span>{{ $setting['company_name'] }}</span> <br/>
                        <span>{{ $setting['company_street_address'] }}</span> <br/>
                        <span>{{ $setting['company_postal_code'].' '.$setting['company_city'] }}</span> <br/>
                    </div>
                </td>
                <td>
                    <img src="{{ isset($check) ? getCompanyLogoUrl() : getCompanyLogoPath() }}" alt="logo"/>
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-box-content m-b-75">
        <table class="table commission-table">
            <tbody>
            <tr>
                <td><strong>{{ trans('Date') }}</strong></td>
                <td><strong>{{ trans('Name') }}</strong></td>
                <td><strong>{{ trans('Bill No') }}</strong></td>
                <td><strong>{{ trans('Sales Volume') }}</strong></td>
                <td><strong>%{{ trans('Provision') }}</strong></td>
                <td><strong>{{ trans('Payment') }}</strong></td>
            </tr>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ getDateInGermany($invoice->invoice_date) }}</td>
                    <td>{{ $invoice->first_name.' '.$invoice->last_name }}</td>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{!! getCurrencyPrice($invoice->total) !!}</td>
                    <td>
                        <?php $invoicePercentage = ($invoice->total >= $setting['threshold_amount'] ? $setting['percentage_above_threshold'] : $setting['commission_percentage']) ?>
                        {{ $invoicePercentage }}%
                    </td>
                    <td>{!! getCurrencyPrice(($invoicePercentage * $invoice->total)/100) !!}</td>
                </tr>
            @endforeach

            @for($i = (config('buch.admin_commission_rows') - $invoices->count()); $i>0; $i--)
                <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            @endfor
            <tr>
                <td></td>
                <td></td>
                <td>@lang('Total gross')</td>
                <td>{!! getCurrencyPrice($commission->total_gross) !!}</td>
                <td></td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('Subtotal')</td>
                <td>{!! getCurrencyPrice($commission->subtotal) !!}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('Taxes') ({{ roundNumber($commission->tax) }}%)</td>
                <td>{!! getCurrencyPrice($commission->tax_total) !!}</td>
            </tr>
            @if($commission->previous_commission_id)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('Unpaid Commission') <br/> (#{{ $commission->previous_commission_id }})</td>
                <td>{!! getCurrencyPrice($commission->previous_unpaid) !!}</td>
            </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>@lang('Total amount')</td>
                <td></td>
                <td>{!! getCurrencyPrice($commission->total) !!}</td>
            </tr>

            <tr class="row-border-less">
                <td colspan="6"></td>
            </tr>

            <tr>
                <td colspan="2">{{ $setting['company_name'] }}</td>
                <td>@lang('Tel'): {{ $setting['company_phone_no'] }}</td>
                <td></td>
                <td colspan="2">Wise TRWIBEB1XXX</td>
            </tr>
            <tr>
                <td>{{ $setting['company_street_address'] }}</td>
                <td>{{ $setting['company_postal_code'].' '.$setting['company_city'] }}</td>
                <td><a href="mailto:{{ $setting['company_email'] }}">{{ $setting['company_email'] }}</a></td>
                <td></td>
                <td colspan="2">IBAN {{ $setting['bank_iban_no'] }}</td>
            </tr>
            <tr>
                <td colspan="3">@lang('Commercial register entry'), @lang('Tax number'): {{ $setting['vat_id'] }}</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3">@lang('Company headquarters') {{ $setting['company_name'] }}</td>
                <td colspan="3"></td>
            </tr>

            </tbody>
        </table>
    </div>

@endsection