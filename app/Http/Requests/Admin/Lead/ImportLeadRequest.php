<?php

namespace App\Http\Requests\Admin\Lead;


use App\Helpers\Config\BuchConfig;
use Illuminate\Foundation\Http\FormRequest;

class ImportLeadRequest extends FormRequest
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
            'file' => ['required', 'mimes:'.implode(',', BuchConfig::getLeadsImportExtensions())],
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
            'file.required' => trans('Excel file is required'),
            'file.mimes' => trans('Excel file is invalid. It must be of types :type', ['type' => implode(',', BuchConfig::getLeadsImportExtensions())]),
        ];
    }
}
