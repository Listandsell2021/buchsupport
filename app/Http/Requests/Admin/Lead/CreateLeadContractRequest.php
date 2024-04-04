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

class CreateLeadContractRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'lead_id'       => ['required', new IsLeadEligibleForNewCustomer(),],
            'document'  => [
                'required',
                File::types(ContractDocConfig::fileExtensions())
                    ->min(ContractDocConfig::minFileSize())
                    ->max(ContractDocConfig::maxFileSize()),
            ],
            'service_id'    => ['required', 'exists:services,id'],
            'quantity'      => ['required'],
            'price'         => ['required'],
            'note'          => ['required'],
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
            'lead_id.required'  => trans('Lead is required'),
            'lead_id.exists'    => trans('Lead does not exists'),
            'service_id.required' => trans('Service is required'),
            'service_id.exists' => trans('Service does not exists'),
            'document.required' => trans('Document is required'),
            'document.types'    => trans('Document must be PDF'),
            'document.min'      => trans('Document must be between 50KB and 2MB'),
            'document.max'      => trans('Document must be between 50KB and 2MB'),
            'quantity.required' => 'Quantity is required',
            'price.required'    => 'Price is required',
            'note.required'     => 'Note is required',
        ];
    }
}
