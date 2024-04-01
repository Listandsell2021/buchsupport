<?php

namespace App\Http\Requests\Admin\Invoice;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\Membership;
use App\Http\Rules\Admin\CheckInvoiceServices;
use App\Http\Rules\Admin\CheckUserFormPattern;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_gender'         => 'required',
            'user_name'           => 'required',
            'user_address'        => 'required',

            'invoice_date'        => 'required|date|date_format:'.getLocaleDateFormat(),
            'user_no'             => 'required',
            'invoice_no'          => ['required', 'unique:invoices,invoice_no'],

            'services'            => ['array', new CheckInvoiceServices()],
            'service_total'       => 'required|numeric|min:1',
            'subtotal'            => 'required|numeric|min:1',
            'vat'                 => 'required|numeric',
            'vat_total'           => 'required|numeric|min:1',
            'total'               => 'required|numeric|min:1',
        ];
    }


    /**
     * Validation Messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_gender.required'         => trans('Client gender is required'),
            'user_name.required'           => trans('Client name is required'),
            'user_address.required'        => trans('Client address is required'),

            'invoice_date.required'        => trans('Invoice date is required'),
            'invoice_date.date'            => trans('Invoice date must be a date'),
            'invoice_date.date_format'     => trans('Invoice date has invalid date format'),
            'user_no.required'             => trans('Client number is required'),
            'invoice_no.required'          => trans('Invoice number is required'),
            'invoice_no.unique'            => trans('Invoice number already exists'),

            'services.required'            => trans('Services are required'),
            'service_total.required'       => trans('Service total price is required'),
            'service_total.numeric'        => trans('Service total price must be number'),
            'service_total.min'            => trans('Service total price must be greater than 0'),
            'subtotal.required'            => trans('Subtotal Price is required'),
            'subtotal.numeric'             => trans('Subtotal Price must be number'),
            'subtotal.min'                 => trans('Subtotal Price must be greater than 0'),
            'vat.required'                 => trans('Vat is required'),
            'vat.numeric'                  => trans('Vat must be number'),
            'vat_total.required'           => trans('Vat Price is required'),
            'vat_total.numeric'            => trans('Vat Price must be a number'),
            'vat_total.min'                => trans('Vat Price must be greater than 0'),
            'total.required'               => trans('Total Price is required'),
            'total.numeric'                => trans('Total Price must be a number'),
            'total.min'                    => trans('Total Price must be greater than 0'),

        ];
    }
}
