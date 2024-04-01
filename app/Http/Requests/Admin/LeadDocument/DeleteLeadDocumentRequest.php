<?php

namespace App\Http\Requests\Admin\LeadDocument;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLeadDocumentRequest extends FormRequest
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
            'document_id' => 'required|exists:lead_documents,id',
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
            'document_id.required'  => trans('Lead document is required'),
            'document_id.exists'    => trans('Lead document does not exists'),
        ];
    }
}
