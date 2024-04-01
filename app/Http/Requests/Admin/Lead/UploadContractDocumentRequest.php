<?php

namespace App\Http\Requests\Admin\Lead;

use App\DataHolders\Enum\LeadStatus;
use App\Helpers\Config\ContractDocConfig;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadContractDocumentRequest extends FormRequest
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
            'lead_id' => 'required|exists:leads,id',
            'document'  => [
                'required',
                File::types(ContractDocConfig::fileExtensions())
                ->min(ContractDocConfig::minFileSize())
                ->max(ContractDocConfig::maxFileSize()),
            ]
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
            'document.required' => trans('Document is required'),
            'document.types'    => trans('Document must be PDF'),
            'document.min'     => trans('Document must be between 50 KB and 5 MB'),
            'document.max'     => trans('Document must be between 50 KB and 5 MB'),
        ];
    }
}
