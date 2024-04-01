<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadStatus;
use App\DataHolders\Enum\Membership;
use App\Helpers\Config\ContractDocConfig;
use App\Http\Rules\Admin\CheckContractProductsPattern;
use App\Http\Rules\Admin\HasConversionRequest;
use App\Http\Rules\Admin\IsLeadEligibleForNewCustomer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AddedNewCustomerRequest extends FormRequest
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
            'contract_id'   => ['nullable', 'exists:lead_contracts,id'],
            'lead_id'       => ['required', new IsLeadEligibleForNewCustomer(), new HasConversionRequest()],
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
        ];
    }
}
