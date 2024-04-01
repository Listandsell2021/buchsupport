<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadStatus;
use App\Http\Rules\Admin\IsLeadEligibleForNewCustomer;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAddedProductRequest extends FormRequest
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
            //'lead_id' => ['required', 'exists:leads,id'],
            'added_product_id' => ['required', 'exists:lead_new_products,id']
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
            'lead_id.required' => trans('Lead is required'),
            'lead_id.exists' => trans('Lead does not exists'),
            'added_product_id.required' => trans('Invalid request'),
            'added_product_id.exists' => trans('Product does not exists'),
        ];
    }
}
