<?php

namespace App\Http\Requests\Admin\Lead;


use App\Http\Rules\Admin\IsLeadEligibleForNewCustomer;
use Illuminate\Foundation\Http\FormRequest;

class ApproveNewCustomerRequest extends FormRequest
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
            'lead_id' => ['required', new IsLeadEligibleForNewCustomer()],
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
        ];
    }
}
