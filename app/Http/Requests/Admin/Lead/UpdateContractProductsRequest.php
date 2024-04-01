<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\LeadStatus;
use App\DataHolders\Enum\Membership;
use App\Http\Rules\Admin\CheckContractProductsPattern;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContractProductsRequest extends FormRequest
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
            'contract_id'   => ['required', 'exists:lead_contracts,id'],
            'products'      => ['required', 'array', new CheckContractProductsPattern()]
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
            'contract_id.required' => trans('Contract is required'),
            'contract_id.exists' => trans('Contract does not exists'),
            'products.required' => trans('Products are required'),
            'products.array'    => trans('Products are invalid'),
        ];
    }
}
