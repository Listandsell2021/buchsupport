<?php

namespace App\Http\Requests\Admin\Invoice;


use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class CancelInvoiceRequest extends FormRequest
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
            'invoice_id'          => ['required',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $invoice = Invoice::find($value);

                    if (!$invoice) {
                        $fail(trans("Invoice does not exists"));
                    }

                    if ($invoice->is_cancelled) {
                        $fail(trans("Invoice is already cancelled"));
                    }
                },
            ],
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
            'invoice_no.required'          => trans('Invoice is required'),
            'invoice_no.exists'            => trans('Invoice does not exists'),
        ];
    }
}
