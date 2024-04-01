<?php

namespace App\Http\Requests\Admin\Mail;

use App\DataHolders\Enum\Gender;
use App\DataHolders\Enum\LeadStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMailRequest extends FormRequest
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
            'id'            => 'required|exists:mail_templates,id',
            'subject'       => 'required',
            'html_template' => 'required',
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
            'id.required' => trans('Mail is required'),
            'id.exists' => trans('Mail does not exists'),
            'subject.required' => trans('Subject is required'),
            'html_template.required' => trans('Template is required'),
        ];
    }
}
